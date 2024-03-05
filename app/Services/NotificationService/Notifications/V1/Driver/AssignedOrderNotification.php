<?php

namespace App\Services\NotificationService\Notifications\V1\Driver;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class AssignedOrderNotification extends Notification implements ShouldBroadcast
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
            'type'    => NotificationType::ASSIGNED_ORDER->value,
            'order'   => [
                'id'         => $this->order->id,
                'created_at' => $this->order->created_at
            ],
            'message' => __('messages.assigned_order')
        ];
    }
}
