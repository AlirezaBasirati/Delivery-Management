<?php

namespace App\Services\NotificationService\Listeners\V1;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Celysium\WebSocket\Events\JoinEvent;

class JoinWebsocketListener
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
    public function handle(JoinEvent $event): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($event->userId);
        $driver = $user->driver;

        if ($user->hasRoles('driver')) {
            $this->broadcastOrderService->sendPendingCount($driver);
            $this->broadcastOrderService->sendPendingList($driver);
        }
    }
}
