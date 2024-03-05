<?php

namespace App\Services\NotificationService\Notifications\V1\Driver;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class OrdersNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct()
    {
    }


    public function via(): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray($notifiable): array
    {
        $orders = $notifiable->driver?->orders()
            ->whereNull('broadcast_orders.assigned_at')
            ->get()
            ->map(function ($order) {
                return [
                    'id'        => $order->id,
                    'pick_ups'  => $order->pick_ups->toArray(),
                    'drop_offs' => $order->drop_offs->toArray(),
                ];
            });

        return [
            'type'    => NotificationType::ORDERS->value,
            'orders'  => $orders->toArray(),
            'message' => __('messages.new_order')
        ];
    }
}
