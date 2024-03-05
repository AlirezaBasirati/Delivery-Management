<?php

namespace App\Services\OrderService\Listeners\V1;

use App\Services\NotificationService\Notifications\V1\Driver\UnAssignedOrderNotification;
use App\Services\OrderService\Events\V1\OrderUnAssignedEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderUnAssignedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderUnAssignedEvent $event): void
    {
        DB::beginTransaction();

        $order = $event->order;
        $driver = $order->driver;

        if (!$driver) {
            return;
        }

        $driver->is_free = true;
        $driver->status = false;
        $driver->distance_from_next_location = null;
        $driver->duration_to_next_location = null;
        $driver->save();

        $order->unAssignedOrders()->create([
            'driver_id'          => $order->driver_id,
            'vehicle_id'         => $order->vehicle_id,
            'static_message_id'  => $event->static_message_id,
            'last_status_log_id' => $event->order_status_log_id
        ]);

        DB::commit();

        if (config('order.send_with_broadcast')) {
            Notification::send([$driver->user], new UnAssignedOrderNotification($order));
        }
    }
}
