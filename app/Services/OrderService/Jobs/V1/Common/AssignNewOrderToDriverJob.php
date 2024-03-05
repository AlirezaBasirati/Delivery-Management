<?php

namespace App\Services\OrderService\Jobs\V1\Common;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignNewOrderToDriverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Order $order, private readonly Driver $driver, private bool $with_broadcast = true)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(BroadcastOrderInterface $broadcast_order): void
    {
        $current_vehicle = $this->driver->current_vehicle;

        // A driver may have accepted the order while we were looking for a driver
        if ($this->order->broadcast_count > 1 && $this->order->refresh()->last_status_id != OrderStatus::PENDING->value) {
            $broadcast_order->fillAssignedAt($this->order);
            return;
        }

        if ($current_vehicle) {
            $broadcast_orders[] = [
                'order_id'   => $this->order->id,
                'driver_id'  => $this->driver->id,
                'vehicle_id' => $current_vehicle->id,
                'priority'   => $this->order->priority
            ];

            $broadcast_order->storeMany($broadcast_orders);

            $this->with_broadcast = $this->with_broadcast ? config('order.send_with_broadcast') : $this->with_broadcast;

            if ($this->with_broadcast) {
                $broadcast_order->sendPendingCount($this->driver);
            }
        }
    }
}
