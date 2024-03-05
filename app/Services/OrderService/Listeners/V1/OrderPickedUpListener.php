<?php

namespace App\Services\OrderService\Listeners\V1;

use App\Services\FleetService\Jobs\V1\Common\SetDistanceFromLocationJob;
use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Events\V1\OrderPickedUpEvent;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Customer\Order\OrderInterface;
use Celysium\WebSocket\Jobs\WebsocketSendOnlyJob;
use Illuminate\Support\Facades\DB;

class OrderPickedUpListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly OrderInterface $orderService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPickedUpEvent $event): void
    {
        DB::beginTransaction();

        $order = $event->order;

        dispatch(new SetDistanceFromLocationJob($order->driver, $order->current_drop_off));

        $location = $order->current_pick_up;

        if ($location) {
            $location->delivered_at = now()->format('Y-m-d H:i:s');
            $location->save();
        }

        $this->orderService->orderInfoNotification($order, NotificationType::PICKED_UP_ORDER);

        DB::commit();
    }
}
