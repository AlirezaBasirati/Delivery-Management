<?php

namespace App\Services\OrderService\Providers;

use App\Services\OrderService\Events\V1\NoDriverFoundEvent;
use App\Services\OrderService\Events\V1\OrderAssignedEvent;
use App\Services\OrderService\Events\V1\OrderDoneEvent;
use App\Services\OrderService\Events\V1\OrderPickedUpEvent;
use App\Services\OrderService\Events\V1\OrderUnAssignedEvent;
use App\Services\OrderService\Listeners\V1\NoDriverFoundListener;
use App\Services\OrderService\Listeners\V1\OrderAssignedListener;
use App\Services\OrderService\Listeners\V1\OrderDoneListener;
use App\Services\OrderService\Listeners\V1\OrderPickedUpListener;
use App\Services\OrderService\Listeners\V1\OrderUnAssignedListener;
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
            OrderAssignedEvent::class,
            [OrderAssignedListener::class, 'handle']
        );

        Event::listen(
            OrderUnAssignedEvent::class,
            [OrderUnAssignedListener::class, 'handle']
        );

        Event::listen(
            OrderPickedUpEvent::class,
            [OrderPickedUpListener::class, 'handle']
        );

        Event::listen(
            OrderDoneEvent::class,
            [OrderDoneListener::class, 'handle']
        );

        Event::listen(
            NoDriverFoundEvent::class,
            [NoDriverFoundListener::class, 'handle']
        );
    }
}
