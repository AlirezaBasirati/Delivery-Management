<?php

namespace App\Services\NotificationService\Providers;

use App\Services\NotificationService\Listeners\V1\IncomingWebsocketListener;
use App\Services\NotificationService\Listeners\V1\JoinWebsocketListener;
use Celysium\WebSocket\Events\IncomingMessageEvent;
use Celysium\WebSocket\Events\JoinEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Event::listen(
            IncomingMessageEvent::class,
            [IncomingWebsocketListener::class, 'handle']
        );

        Event::listen(
            JoinEvent::class,
            [JoinWebsocketListener::class, 'handle']
        );
    }
}
