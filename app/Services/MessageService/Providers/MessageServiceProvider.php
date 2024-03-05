<?php

namespace App\Services\MessageService\Providers;

use App\Services\MessageService\Repository\V1\Admin\StaticMessage\StaticMessageInterface as AdminStaticMessageInterface;
use App\Services\MessageService\Repository\V1\Admin\StaticMessage\StaticMessageRepository as AdminStaticMessageRepository;
use App\Services\MessageService\Repository\V1\Admin\StaticMessageGroup\StaticMessageGroupInterface as AdminStaticMessageGroupInterface;
use App\Services\MessageService\Repository\V1\Admin\StaticMessageGroup\StaticMessageGroupRepository as AdminStaticMessageGroupRepository;
use App\Services\MessageService\Repository\V1\Common\StaticMessage\StaticMessageInterface as DriverStaticMessageInterface;
use App\Services\MessageService\Repository\V1\Common\StaticMessage\StaticMessageRepository as DriverStaticMessageRepository;
use App\Services\MessageService\Repository\V1\Common\StaticMessageGroup\StaticMessageGroupInterface as DriverStaticMessageGroupInterface;
use App\Services\MessageService\Repository\V1\Common\StaticMessageGroup\StaticMessageGroupRepository as DriverStaticMessageGroupRepository;
use App\Services\MessageService\Repository\V1\Common\Ticket\TicketInterface;
use App\Services\MessageService\Repository\V1\Common\Ticket\TicketRepository;
use App\Services\MessageService\Repository\V1\Common\TicketMessage\TicketMessageInterface;
use App\Services\MessageService\Repository\V1\Common\TicketMessage\TicketMessageRepository;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AdminStaticMessageInterface::class, AdminStaticMessageRepository::class);
        $this->app->bind(AdminStaticMessageGroupInterface::class, AdminStaticMessageGroupRepository::class);

        $this->app->bind(DriverStaticMessageInterface::class, DriverStaticMessageRepository::class);
        $this->app->bind(DriverStaticMessageGroupInterface::class, DriverStaticMessageGroupRepository::class);

        $this->app->bind(TicketInterface::class, TicketRepository::class);
        $this->app->bind(TicketMessageInterface::class, TicketMessageRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/driver.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/customer.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
