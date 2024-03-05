<?php

namespace App\Services\NotificationService\Notifications\V1\Driver;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class OrdersCountNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct()
    {
    }


    public function via(): array
    {
        return ['broadcast'];
//        return ['broadcast', 'database'];
    }

//    public function toArray($notifiable): array
//    {
//        return [
//            'type'    => NotificationType::PENDING_ORDERS_COUNT->value,
//            'count'   => $notifiable->driver->broadcastOrders()->whereNull('assigned_at')->count(),
//            'message' => __('messages.new_order')
//        ];
//    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type'    => NotificationType::PENDING_ORDERS_COUNT->value,
            'count'   => $notifiable->driver->broadcastOrders()->whereNull('assigned_at')->count(),
            'message' => __('messages.new_order')
        ]);
    }
}
