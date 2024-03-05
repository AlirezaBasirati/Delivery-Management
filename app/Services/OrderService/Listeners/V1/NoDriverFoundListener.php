<?php

namespace App\Services\OrderService\Listeners\V1;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Events\V1\OrderAssignedEvent;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Celysium\WebSocket\Jobs\WebsocketSendOnlyJob;

class NoDriverFoundListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly BroadcastOrderInterface $broadcastOrderService
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

        $this->broadcastOrderService->fillAssignedAt($order);

        $data = [
            'type'    => NotificationType::NO_DRIVER_FOUND->value,
            'payload' => [
                'order_id' => $order->id
            ]
        ];

        dispatch(new WebsocketSendOnlyJob($data, [$order->customer->user_id]));
    }
}
