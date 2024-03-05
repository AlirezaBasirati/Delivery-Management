<?php

namespace App\Services\OrderService\Repository\V1\Customer\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Enumerations\V1\OrderAssignmentPriority;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepository;
use Celysium\WebSocket\Jobs\WebsocketSendOnlyJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(Order $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'customer_id' => '='
        ];
    }

    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection
    {
        $parameters['customer_id'] = Auth::user()->customer?->id;

        return parent::index($parameters);
    }

    public function currents(): array|\Illuminate\Database\Eloquent\Collection
    {
        /** @var User $user */
        $user = Auth::user();

        return $this->model->query()
            ->where(function ($query) {
                $query->where('is_processing', true)
                    ->orWhereNull('driver_id');
            })
            ->where('customer_id', $user->customer->id)
            ->get();
    }

    public function orderInfoNotification(Order $order, NotificationType $type): void
    {
        $driver = $order->driver;
        $user = $driver->user;

        $data = [
            'type'    => $type->value,
            'payload' => [
                'driver'  => [
                    'id'                          => $driver->id,
                    'user'                        => $user->only('id', 'first_name', 'last_name'),
                    'distance_from_next_location' => $driver->distance_from_next_location,
                    'duration_to_next_location'   => $driver->duration_to_next_location,
                ],
                'vehicle' => $order->vehicle->only('id', 'title', 'plate_number')
            ]
        ];

        dispatch(new WebsocketSendOnlyJob($data, [$order->customer->user_id]));
    }

    public function hurry(Order $order): void
    {
        $order->update(['priority' => OrderAssignmentPriority::HIGH->value]);
    }
}
