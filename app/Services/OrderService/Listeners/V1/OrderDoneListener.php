<?php

namespace App\Services\OrderService\Listeners\V1;

use App\Services\FleetService\Jobs\V1\Common\SetDistanceFromLocationJob;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Events\V1\OrderDoneEvent;
use App\Services\OrderService\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;

class OrderDoneListener
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
    public function handle(OrderDoneEvent $event): void
    {
        DB::beginTransaction();

        $order = $event->order;

        /** @var OrderStatusLog $return_status */
        $return_status = $order->statusLogs()
            ->whereIn('order_status_id', [
                OrderStatus::PARTIAL_RETURN,
                OrderStatus::COMPLETE_RETURN,
                OrderStatus::ABSENCE_OF_RECEIVER
            ])
            ->first();

        if ($return_status) {
            $order->last_status_id = $return_status->order_status_id;
        }

        $order->locations()
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->whereNull('delivered_at')
            ->take(1)
            ->update(['delivered_at' => now()->format('Y-m-d H:i:s')]);

        if ($order->next_status) {
            dispatch(new SetDistanceFromLocationJob($order->driver, $order->current_drop_off));
        }
        else {
            $order->is_processing = false;
            $order->save();

            $driver = $order->driver;

            $driver->is_free = true;
            $driver->distance_from_next_location = null;
            $driver->duration_to_next_location = null;
            $driver->save();
        }

        DB::commit();
    }
}
