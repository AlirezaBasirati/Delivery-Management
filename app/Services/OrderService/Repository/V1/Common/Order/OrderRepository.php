<?php

namespace App\Services\OrderService\Repository\V1\Common\Order;

use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerInterface;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface;
use App\Services\NotificationService\Notifications\V1\Driver\UnAssignedOrderNotification;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Jobs\V1\Common\BroadcastOrderJob;
use App\Services\OrderService\Jobs\V1\Common\FindDriversJob;
use App\Services\OrderService\Jobs\V1\Common\SetAddressForOrderLocationJob;
use App\Services\OrderService\Jobs\V1\Common\SetScheduleDataJob;
use App\Services\OrderService\Libraries\ArrayOptions;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderLocation;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderItem\OrderItemInterface;
use App\Services\OrderService\Repository\V1\Common\OrderLocation\OrderLocationInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;
use App\Services\PlanningService\Repositories\V1\Common\ReservedSchedule\ReservedScheduleInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(
        Order                                      $model,
        private readonly OrderLocationInterface    $orderLocationService,
        private readonly OrderItemInterface        $orderItemService,
        private readonly OrderStatusLogInterface   $orderStatusLog,
        private readonly BroadcastOrderInterface   $broadcastOrder,
        private readonly CustomerInterface         $customerService,
        private readonly ReservedScheduleInterface $reservedScheduleService,
        private readonly DriverInterface           $driverService
    )
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'id'               => '=',
            'ids'              => fn($value) => $query->whereIn('id', $value),
            'code'             => fn($value) => $query->where('orders.code', $value),
            'customer_id'      => '=',
            'type'             => fn($value) => $query->where('orders.type', $value),
            'is_cod'           => fn($value) => $query->when($value, function ($query) {
                $query->where('cod_amount', '>', 0);
            })->when(!$value, function ($query) {
                $query->where('cod_amount', 0);
            }),
            'package_quantity' => '=',
            'driver_id'        => '=',
            'vehicle_id'       => '=',
            'status_ids'       => fn($value) => $query->whereIn('orders.last_status_id', $value),
            'created_from'     => fn($value) => $query->where('orders.created_at', '>=', $value),
            'created_to'       => fn($value) => $query->where('orders.created_at', '<=', $value),
        ];
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $query->where('tenant_id', auth()->user()->tenant_id)
            ->when($parameters['search'] ?? null, function ($query, $search) {
                $query->join('order_locations', 'orders.id', '=', 'order_locations.order_id')
                    ->where(function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('order_locations.name', 'LIKE', "%$search%")
                                ->orWhere('order_locations.phone', 'LIKE', "%$search%");
                        })
                            ->orWhere('orders.code', 'LIKE', "%$search%")
                            ->orWhere('orders.id', 'LIKE', "%$search%");
                    })
                    ->select('orders.*')
                    ->distinct('orders.id');
            })->when(isset($parameters['state_ids']), function ($query, $state_ids) {
                $query->join('order_statuses', 'orders.last_status_id', '=', 'order_statuses.id')
                    ->whereIn('order_statuses.state_id', $state_ids)
                    ->select('orders.*')
                    ->distinct('orders.id');
            });

        return parent::query($query, $parameters);
    }

    /**
     * @throws ValidationException
     */
    public function store(array $parameters): Model
    {
        DB::beginTransaction();

        if (!isset($parameters['customer_id'])) {
            $parameters['customer']['tenant_id'] = $parameters['tenant_id'];
            $customer = $this->customerService->firstOrCreate($parameters['customer']);
            $parameters['customer_id'] = $customer->id;

            unset($parameters['customer']);
        }

        $is_schedule = $parameters['type'] == OrderType::SCHEDULED->value;

        if ($is_schedule) {
            $reserve_schedule = $this->reservedScheduleService->checkReserve([
                'customer_id' => $parameters['customer_id'],
                'schedule_id' => $parameters['schedule_id']
            ], true);

            if (!$reserve_schedule) {
                throw ValidationException::withMessages(['schedule_id' => __('messages.capacity_is_not_reserved')]);
            }
        }
        else {
            $parameters['schedule_id'] = null;
        }

        /** @var Order $model */
        $model = parent::store($parameters);

        if (isset($parameters['items'])) {
            ArrayOptions::pushToItems($parameters['items'], ['order_id' => $model->id]);
            $this->orderItemService->storeMany($parameters['items']);
        }

        ArrayOptions::pushToItems($parameters['locations'], ['order_id' => $model->id]);
        $this->orderLocationService->storeMany($parameters['locations']);

        DB::commit();

        SetScheduleDataJob::dispatchIf($is_schedule, $model);

        return $model->refresh();
    }

    public function cancel(Order $order, int $status_id = null): Order
    {
        DB::beginTransaction();

        $order->is_processing = false;
        $order->save();

        if ($order->driver_id) {
            $driver = $order->driver;

            $driver->is_free = true;
            $driver->distance_from_next_location = null;
            $driver->duration_to_next_location = null;
            $driver->save();

            if (config('order.send_with_broadcast')) {
                Notification::send([$order->driver->user], new UnAssignedOrderNotification($order));
            }
        }

        $this->broadcastOrder->fillAssignedAt($order);

        dispatch_sync(new BroadcastOrderJob($order));

        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => $status_id ?? OrderStatus::SUPPORT_CANCELED->value]);

        DB::commit();

        return $order->refresh();
    }

    public function assignDriver(Order $order, Driver $driver, array $parameters): Order
    {
        $last_status = $order->lastStatus;

        // If order has not been picked up yet, then the pickup of the order will not change
        $this->setNewPickUp($order, $parameters);

        if (isset($order->driver_id)) {
            $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => $this->unAssignStatus($order)->value]);
        }

        $order->driver_id = $driver->id;
        $order->vehicle_id = $driver->currentVehicle->id;
        $order->save();

        $order->refresh();

        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::ASSIGNED->value]);

        if ($last_status->id == OrderStatus::PENDING->value) {
            dispatch(new BroadcastOrderJob($order));
        }

        return $order->refresh();
    }

    public function unAssignDriver(Order $order, array $parameters): Order
    {
        // If order has not been picked up yet, then the pickup of the order will not change
        $this->setNewPickUp($order, $parameters);

        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => $this->unAssignStatus($order)->value]);

        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::PENDING->value]);

        $order->driver_id = null;
        $order->vehicle_id = null;
        $order->save();

        return $order->refresh();
    }

    public function broadcast(Order $order, array $parameters): Order
    {
        // If order has not been picked up yet, then the pickup of the order will not change
        $this->setNewPickUp($order, $parameters);

        $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::PENDING->value]);

        dispatch(new FindDriversJob($order));

        return $order->refresh();
    }

    public function count(): Collection
    {
        return $this->model->query()
            ->select('last_status_id', DB::raw('count(*) as count'))
            ->where('tenant_id', auth()->user()->tenant_id)
            ->groupBy('last_status_id')
            ->get();
    }

    public function setNewPickUp(Order $order, array $parameters): void
    {
        $status = $this->unAssignStatus($order);

        if ($status->value == OrderStatus::UNASSIGNED_AFTER_PICKED_UP->value) {
            if (!isset($parameters['pick_up'])) {
                $old_driver = $order->driver;

                if (!$old_driver) {
                    $unAssigned_order = $order->unAssignedOrders()->latest()->first();
                    $old_driver = $unAssigned_order->driver;
                }

                $user = $old_driver->user;

                $parameters['pick_up'] = [
                    'latitude'  => $old_driver->latitude,
                    'longitude' => $old_driver->longitude,
                    'name'      => $user->full_name,
                    'phone'     => $user->mobile
                ];
            }

            $parameters['pick_up']['sort'] = $order->pick_ups->max('sort');
            $parameters['pick_up']['type'] = OrderLocationType::PICK_UP->value;

            /** @var OrderLocation $location */
            $location = $order->locations()->create($parameters['pick_up']);
            dispatch(new SetAddressForOrderLocationJob($location));
        }
    }

    public function unAssignStatus(Order $order): OrderStatus
    {
        return is_null($order->current_pick_up) ?
            OrderStatus::UNASSIGNED_AFTER_PICKED_UP :
            OrderStatus::UNASSIGNED_BEFORE_PICKED_UP;
    }

    /**
     * @throws ValidationException
     */
    public function bulkAssignDriver(array $parameters): void
    {
        $orders = $this->model->query()
            ->whereIn('id', $parameters['order_ids'])
            ->where('type', OrderType::SCHEDULED->value);

        $invalid = $orders->clone()
            ->whereNotNull('driver_id')
            ->count();

        if ($invalid) {
            throw ValidationException::withMessages(['order_ids' => __('messages.can_not_bulk_assign_driver_to_orders')]);
        }

        /** @var Driver $driver */
        $driver = $this->driverService->find($parameters['driver_id']);

        DB::beginTransaction();

        $orders->clone()->update([
            'driver_id' => $parameters['driver_id'],
            'vehicle_id' => $driver->currentVehicle?->id
        ]);

        foreach ($orders->get() as $order) {
            $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::ASSIGNED->value]);
        }

        DB::commit();
    }

    public function bulkDispatch(array $parameters): void
    {
        $orders = $this->model->query()
            ->where('type', OrderType::SCHEDULED->value)
            ->where('last_status_id', OrderStatus::ASSIGNED->value)
            ->when($parameters['driver_id'] ?? null, function ($query, $driver_id) {
                $query->where('driver_id', $driver_id);
            })
            ->when($parameters['order_ids'] ?? null, function ($query, $order_ids) {
                $query->whereIn('id', $order_ids);
            })
            ->get();

        DB::beginTransaction();

        foreach ($orders as $order) {
            $this->orderStatusLog->store(['order_id' => $order->id, 'order_status_id' => OrderStatus::PICKED_UP->value]);
        }

        DB::commit();
    }
}
