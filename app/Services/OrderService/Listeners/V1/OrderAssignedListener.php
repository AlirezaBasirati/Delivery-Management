<?php

namespace App\Services\OrderService\Listeners\V1;

use App\Services\FleetService\Jobs\V1\Common\SetDistanceFromLocationJob;
use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\NotificationService\Notifications\V1\Driver\AssignedOrderNotification;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Events\V1\OrderAssignedEvent;
use App\Services\OrderService\Jobs\V1\Common\BroadcastOrderJob;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use App\Services\OrderService\Repository\V1\Customer\Order\OrderInterface;
use Celysium\WebSocket\Jobs\WebsocketSendOnlyJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderAssignedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly BroadcastOrderInterface $broadcastOrderService,
        private readonly OrderInterface $orderService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderAssignedEvent $event): void
    {
        $order = $event->order;
        $driver = $order->driver;

        if ($order->type == OrderType::ON_DEMAND->value) {
            dispatch(new SetDistanceFromLocationJob($driver, $order->current_pick_up));

            dispatch(new BroadcastOrderJob($order));

            DB::beginTransaction();

            $order->is_processing = true;
            $order->save();

            $driver->is_free = false;
            $driver->save();

            $this->broadcastOrderService->fillAssignedAt($order);

            DB::commit();
        }

        $this->orderService->orderInfoNotification($order, NotificationType::ASSIGNED_ORDER);
    }
}
