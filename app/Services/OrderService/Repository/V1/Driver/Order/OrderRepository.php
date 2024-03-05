<?php

namespace App\Services\OrderService\Repository\V1\Driver\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Jobs\V1\Common\SetDistanceFromLocationJob;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Enumerations\V1\TenantWebhookCallType;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Libraries\ArrayOptions;
use App\Services\OrderService\Models\BroadcastOrder;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderItem;
use App\Services\OrderService\Models\OrderLocation;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface as CommonOrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderLocation\OrderLocationInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Spatie\WebhookServer\WebhookCall;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(
        Order                                    $model,
        private readonly OrderLocation           $orderLocation,
        private readonly BroadcastOrderInterface $broadcastOrderService,
        private readonly OrderStatusLogInterface $orderStatusLogService,
        private readonly CommonOrderInterface    $commonOrderService,
        private readonly OrderLocationInterface  $orderLocationService

    )
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [];
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $query->when($parameters['driver_id'] ?? null, function ($query, $driver_id) {
            $query->leftJoin('un_assigned_orders', 'orders.id', '=', 'un_assigned_orders.order_id')
                ->where(function ($query) use ($driver_id) {
                    $query->where('orders.driver_id', $driver_id)
                        ->orWhere('un_assigned_orders.driver_id', $driver_id);
                })
                ->with('unAssignedOrders')
                ->select('orders.*');
        })
            ->when($parameters['search'] ?? null, function ($query, $search) {
                $query->leftJoin('order_locations', 'orders.id', '=', 'order_locations.order_id')
                    ->where(function ($query) use ($search) {
                        $query->where('order_locations.name', 'LIKE', "%$search%")
                            ->orWhere('order_locations.address', 'LIKE', "%$search%")
                            ->orWhere('order_locations.phone', 'LIKE', "%$search%");
                    })
                    ->select('orders.*')
                    ->distinct('orders.id');
            });

        return parent::query($query, $parameters);
    }

    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection
    {
        $parameters['driver_id'] = Auth::user()->driver?->id;

        return parent::index($parameters);
    }

    /**
     * @return Order|null
     */
    public function current(): ?Model
    {
        $driver = Auth::user()->driver;

        return $this->model->query()
            ->where('driver_id', $driver->id)
            ->where('is_processing', true)
            ->firstOrFail();
    }

    public function scheduledList(): LengthAwarePaginator|Collection
    {
        $driver = Auth::user()->driver;

        return $this->model->query()
            ->where('driver_id', $driver->id)
            ->where('type', OrderType::SCHEDULED->value)
            ->whereDate('start_of_schedule', now()->format('Y-m-d'))
            ->whereNotIn('last_status_id', OrderStatus::complete())
            ->orderBy('start_of_schedule')
            ->with('schedule.timeslot')
            ->paginate();
    }

    public function items(): ?Collection
    {
        return $this->current()->items;
    }

    public function accept(array $parameters = []): ?Model
    {
        DB::beginTransaction();

        $driver = Auth::user()->driver;

        $specific_order = isset($parameters['order_id']);

        if (!$specific_order) {
            /** @var BroadcastOrder $broadcast_order */
            $broadcast_order = $this->broadcastOrderService->selectForDriver($driver);

            if (!$broadcast_order) {
                return null;
            }

            $parameters['order_id'] = $broadcast_order->order_id;
        }

        $orderQuery = $this->model->query()
            ->where('id', $parameters['order_id']);

        /** @var Order $order */
        $order = (clone $orderQuery)->first();

        if ($order) {
            $updated = $orderQuery
                ->whereNull('driver_id')
                ->lockForUpdate()
                ->update([
                    'driver_id'  => $driver->id,
                    'vehicle_id' => $driver->currentVehicle->id,
                ]);

            if ($updated) {
                DB::commit();

                $order = $order->refresh();

                $this->orderStatusLogService->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::ASSIGNED->value]);

                return $order;
            }

            DB::rollBack();
        }

        if ($order->driver_id) {
            $this->broadcastOrderService->fillAssignedAt($order);
        }

        return $specific_order ? null : $this->accept();
    }

    public function changeStatus(array $parameters): void
    {
        $order = $parameters['order'];

        $this->orderStatusLogService->store(['order_id' => $order->id, 'order_status_id' => $parameters['status']->id]);
    }


    public function select(Order $order): void
    {
        DB::beginTransaction();

        $order->is_processing = 1;
        $order->save();

        dispatch(new SetDistanceFromLocationJob($order->driver, $order->current_drop_off));

        $this->orderStatusLogService->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::ON_THE_WAY->value]);

        DB::commit();
    }

    public function unAssign(array $parameters): void
    {
        /** @var Order $order */
        $order = $this->current();

//        if (config('order.send_with_broadcast')) {
//            $users = $this->userService->index(['paginate' => false, 'role_id' => Role::ADMIN->value]);
//            Notification::send($users, new UnAssignedOrderByDriverNotification($order));
//        }

        $status = $this->commonOrderService->unAssignStatus($order)->value;

        $this->orderStatusLogService->store(['order_id' => $order->id, 'order_status_id' => $status]);

        $order->driver_id = null;
        $order->vehicle_id = null;
        $order->save();
    }

    /**
     * @throws ValidationException
     */
    public function return(array $parameters): void
    {
        DB::beginTransaction();

        /** @var Order $order */
        $order = $this->current();
        $order_items = $order->items();

        if (
            $order->next_status->id != OrderStatus::DONE->value ||
            $order_items->clone()->where('returned_quantity', '>', 0)->exists() ||
            $order->drop_offs->count() > 1
        ) {
            throw ValidationException::withMessages([
                "order" => [
                    __('messages.can_not_return')
                ]
            ]);
        }

        $returned_items = $this->returnItems($order, $parameters['items'] ?? []);

        // We check the return status here because the items need to be checked first to determine that the entries were correct
        $status_id = $this->specifyReturnStatus($order, $parameters['type'] ?? null);

        $forbidden_return = $status_id == OrderStatus::PARTIAL_RETURN->value
            && isset($order->permissions['partial_return'])
            && !$order->permissions['partial_return'];

        $forbidden_partial_return = $status_id != OrderStatus::ABSENCE_OF_RECEIVER->value
            && isset($order->permissions['return'])
            && !$order->permissions['return'];

        if ($forbidden_return || $forbidden_partial_return) {
            throw ValidationException::withMessages([
                "order" => [
                    __('messages.can_not_return')
                ]
            ]);
        }

        $this->orderStatusLogService->store([
            'order_id'        => $order->id,
            'order_status_id' => $status_id
        ]);

        $this->setReturnDropOff($order);

        DB::commit();

        WebhookCall::create()
            ->url($order->tenant->webhook_url)
            ->payload([
                'type'    => TenantWebhookCallType::RETURN_ORDER->value,
                'payload' => [
                    'id'          => $order->id,
                    'code'        => $order->code,
                    'return_type' => strtolower(OrderStatus::from($status_id)->name),
                    'items'       => $returned_items,
                ]
            ])
            ->useSecret(env('ZOOT_WEBHOOK_SECRET'))
            ->dispatch();
    }

    /**
     * @throws ValidationException
     */
    private function returnItems(Order $order, array $items = []): array
    {
        $returned_items = [];

        $items_query = $order->items();

        if (count($items)) {
            $items_query = $items_query->get();

            foreach ($items as $key => $item) {
                /** @var OrderItem $order_item */
                $order_item = $items_query->find($item['id']);

                if (!$order_item) {
                    throw ValidationException::withMessages([
                        "items.$key.id" => [
                            __('messages.item_not_exists_in_the_order', ['attribute' => $item['id']])
                        ]
                    ]);
                } elseif ($order_item->quantity - $order_item->returned_quantity < $item['returned_quantity']) {
                    throw ValidationException::withMessages([
                        "items.$key.returned_quantity" => [
                            __('messages.returned_quantity_is_greater_than_quantity', ['attribute' => $order_item->name])
                        ]
                    ]);
                }

                $order_item->returned_quantity += $item['returned_quantity'];
                $order_item->save();

                $returned_items[] = $order_item->only('material_code', 'name', 'returned_quantity');
            }
        } else {
            $items_query->clone()->update([
                'returned_quantity' => DB::raw('quantity')
            ]);

            $returned_items = $items_query->select('material_code', 'name', 'returned_quantity')
                ->get()
                ->toArray();
        }

        return $returned_items;
    }

    private function setReturnDropOff(Order $order): void
    {
        $order->locations()
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->whereNull('delivered_at')
            ->update(['delivered_at' => now()->format('Y-m-d H:i:s')]);

        /** @var OrderLocation $first_pick_up */
        $first_pick_up = $order->pick_ups->first();

        $drop_off = $first_pick_up->only('latitude', 'longitude', 'name', 'address', 'phone', 'postal_code');
        $drop_off['type'] = OrderLocationType::DROP_OFF->value;
        $drop_off['sort'] = $order->drop_offs->max('sort') + 1;

        $order->locations()->create($drop_off);

        dispatch(new SetDistanceFromLocationJob($order->driver, $first_pick_up));
    }

    private function specifyReturnStatus(Order $order, ?string $type): int
    {
        if ($type) {
            if ($type == strtolower(OrderStatus::ABSENCE_OF_RECEIVER->name)) {
                return OrderStatus::ABSENCE_OF_RECEIVER->value;
            } elseif ($type == strtolower(OrderStatus::COMPLETE_RETURN->name)) {
                return OrderStatus::COMPLETE_RETURN->value;
            }
            // we do not check the partial return of the order here, because the user may have entered the partial return as type by mistake and sent all items to return
        }

        $is_partial_return = $order->items()->whereRaw('quantity > returned_quantity')->exists();

        return $is_partial_return ? OrderStatus::PARTIAL_RETURN->value : OrderStatus::COMPLETE_RETURN->value;
    }

    public function storeNeedSupportLog(): void
    {
        $order = $this->current();

        $this->orderStatusLogService->store([
            'order_id'        => $order->id,
            'order_status_id' => OrderStatus::NEED_SUPPORT->value
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function reorderLocations(array $parameters): void
    {
        $order = $this->current();

        $current_drop_off = $order->current_drop_off;

        $locationIds = array_column($parameters['items'], 'id');

        $locationsCount = $this->orderLocation->query()
            ->whereIn('id', $locationIds)
            ->where('order_id', $order->id)
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->count();

        if ($locationsCount !== count($locationIds)) {
            throw ValidationException::withMessages(['items' => __('messages.location_not_for_this_order')]);
        }

        ArrayOptions::pushToItems($parameters['items'], ['type' => OrderLocationType::DROP_OFF->value]);

        $this->orderLocationService->setSort($parameters['items']);

        DB::beginTransaction();
        foreach ($parameters['items'] as $item) {
            $this->orderLocation->query()
                ->where('id', $item['id'])
                ->update($item);
        }
        DB::commit();

        $new_current_drop_off = $order->current_drop_off;

        if ($current_drop_off->id == $new_current_drop_off->id) {
            /** @var User $user */
            $user = Auth::user();

            dispatch(new SetDistanceFromLocationJob($user->driver, $new_current_drop_off));
        }
    }
}
