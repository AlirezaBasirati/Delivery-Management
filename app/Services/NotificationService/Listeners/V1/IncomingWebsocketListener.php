<?php

namespace App\Services\NotificationService\Listeners\V1;

use App\Services\FleetService\Repository\V1\Driver\DriverLocation\DriverLocationInterface;
use App\Services\NotificationService\Enumerations\V1\NotificationType;
use Celysium\WebSocket\Events\IncomingMessageEvent;

class IncomingWebsocketListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly DriverLocationInterface $driverLocationService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IncomingMessageEvent $event): void
    {
        if ($event->data['type'] == NotificationType::DRIVER_LOCATION->value) {
            if (!isset($event->data['payload']['latitude']) || !isset($event->data['payload']['longitude'])) {
                return;
            }

            $this->driverLocationService->store([
                'user_id'   => $event->userId,
                'latitude'  => $event->data['payload']['latitude'],
                'longitude' => $event->data['payload']['longitude'],
            ]);
        }
    }
}
