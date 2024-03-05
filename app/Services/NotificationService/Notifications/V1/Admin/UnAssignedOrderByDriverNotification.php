<?php

namespace App\Services\NotificationService\Notifications\V1\Admin;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class UnAssignedOrderByDriverNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(private readonly Order $order)
    {
    }


    public function via(): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray(): array
    {
        return [
            'type'    => NotificationType::UN_ASSIGN_ORDER_BY_DRIVER->value,
            'order'   => [
                'id'         => $this->order->id,
                'driver'     => $this->order->driver?->user?->full_name,
                'created_at' => $this->order->created_at
            ],
            'message' => __('messages.un_assigned_order_by_driver')
        ];
    }
}
