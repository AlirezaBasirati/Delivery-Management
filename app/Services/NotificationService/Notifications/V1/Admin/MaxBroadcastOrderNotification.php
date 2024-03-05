<?php

namespace App\Services\NotificationService\Notifications\V1\Admin;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class MaxBroadcastOrderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public array $order;

    public function __construct(Order $order)
    {
        $this->order = [
            'id'              => $order->id,
            'created_at'      => $order->created_at,
            'broadcast_count' => $order->broadcast_count
        ];
    }


    public function via(): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray(): array
    {
        return [
            'type'    => NotificationType::MAX_BROADCAST_ORDER->value,
            'order'   => $this->order,
            'message' => __('messages.max_broadcast_count', ['n' => $this->order['broadcast_count']])
        ];
    }
}
