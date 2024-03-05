<?php

namespace App\Services\OrderService\Repository\V1\Common\BroadcastOrder;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Models\BroadcastOrder;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepository;
use Celysium\WebSocket\Jobs\WebsocketSendOnlyJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BroadcastOrderRepository extends BaseRepository implements BroadcastOrderInterface
{
    public function __construct(BroadcastOrder $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'order_id'    => '=',
            'driver_id'   => '=',
            'vehicle_id'  => '=',
            'is_assigned' => fn($value) => $query->when($value, function ($query) {
                $query->whereNotNull('assigned_at');
            })->when(!$value, function ($query) {
                $query->whereNull('assigned_at');
            })
        ];
    }

    public function storeMany(array $parameters): bool
    {
        DB::beginTransaction();

        foreach ($parameters as $parameter) {
            $this->model->query()->updateOrCreate([
                'order_id'   => $parameter['order_id'],
                'driver_id'  => $parameter['driver_id'],
                'vehicle_id' => $parameter['vehicle_id'],
                'priority'   => $parameter['priority']
            ], [
                'broadcast_count' => DB::raw('broadcast_count + 1'),
                'assigned_at'     => null
            ]);
        }

        DB::commit();

        return true;
    }

    public function fillAssignedAt(Order $order, array $except_drivers = []): void
    {
        $this->model->query()
            ->where('order_id', $order->id)
            ->whereNull('assigned_at')
            ->whereNotIn('driver_id', $except_drivers)
            ->update(['assigned_at' => now()]);
    }

    public function selectForDriver(Driver $driver): ?Model
    {
        return $this->model->query()
            ->whereNull('assigned_at')
            ->where('driver_id', $driver->id)
            ->latest('broadcast_count')
            ->orderBy('priority')
            ->orderBy('created_at')
            ->first();
    }

    private function pendingQuery(Driver $driver): Builder
    {
        return $this->model->query()
            ->where('driver_id', $driver->id)
            ->whereNull('assigned_at');
    }

    public function pendingCount(User $user): int
    {
        return $this->pendingQuery($user->driver)->count();
    }

    public function pendingList(Driver $driver): array
    {
        return $this->pendingQuery($driver)
            ->with(['order', 'order.locations'])
            ->get()
            ->map(function ($broadcast_order) {
                /** @var Order $order */
                $order = $broadcast_order->order;

                return [
                    'id'        => $order->id,
                    'price'     => $order->price,
                    'pick_up'   => $order->current_pick_up->only('id', 'name', 'address'),
                    'drop_offs' => $order->drop_offs->map(function ($drop_off) {
                        return $drop_off->only('id', 'name', 'address');
                    })->toArray()
                ];
            })->toArray();
    }

    public function sendPendingCount(Driver $driver): void
    {
        $user = $driver->user;

        $data = [
            'type'    => NotificationType::PENDING_ORDERS_COUNT->value,
            'payload' => [
                'count' => $this->pendingCount($user),
            ]
        ];

        dispatch(new WebsocketSendOnlyJob($data, (array)$user->id));
    }

    public function sendPendingList(Driver $driver): void
    {
        $data = [
            'type'    => NotificationType::PENDING_ORDERS_LIST->value,
            'payload' => [
                'orders' => $this->pendingList($driver),
            ]
        ];

        dispatch(new WebsocketSendOnlyJob($data, (array)$driver->user_id));
    }
}
