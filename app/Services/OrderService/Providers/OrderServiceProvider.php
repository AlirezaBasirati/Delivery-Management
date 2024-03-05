<?php

namespace App\Services\OrderService\Providers;

use App\Services\OrderService\Console\Commands\V1\ArchiveBroadcastOrder;
use App\Services\OrderService\Console\Commands\V1\BroadcastPendingOrdersCommand;
use App\Services\OrderService\Console\Commands\V1\CacheDispatcherDashboardCommand;
use App\Services\OrderService\Repository\V1\Admin\OrderState\OrderStateInterface as AdminOrderStateInterface;
use App\Services\OrderService\Repository\V1\Admin\OrderState\OrderStateRepository as AdminOrderStateRepository;
use App\Services\OrderService\Repository\V1\Admin\OrderStatus\OrderStatusInterface as AdminOrderStatusInterface;
use App\Services\OrderService\Repository\V1\Admin\OrderStatus\OrderStatusRepository as AdminOrderStatusRepository;
use App\Services\OrderService\Repository\V1\Customer\Order\OrderInterface as CustomerOrderInterface;
use App\Services\OrderService\Repository\V1\Customer\Order\OrderRepository as CustomerOrderRepository;
use App\Services\OrderService\Repository\V1\Driver\OrderStatus\OrderStatusInterface as DriverOrderStatusInterface;
use App\Services\OrderService\Repository\V1\Driver\OrderStatus\OrderStatusRepository as DriverOrderStatusRepository;
use App\Services\OrderService\Repository\V1\Admin\Order\OrderInterface as AdminOrderInterface;
use App\Services\OrderService\Repository\V1\Admin\Order\OrderRepository as AdminOrderRepository;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface as CommonOrderInterface;
use App\Services\OrderService\Repository\V1\Common\Order\OrderRepository as CommonOrderRepository;
use App\Services\OrderService\Repository\V1\Common\OrderStatus\OrderStatusInterface as CommonOrderStatusInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatus\OrderStatusRepository as CommonOrderStatusRepository;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface as CommonOrderStatusLogInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogRepository as CommonOrderStatusLogRepository;
use App\Services\OrderService\Repository\V1\Tenant\OrderStatusLog\OrderStatusLogInterface as TenantOrderStatusLogInterface;
use App\Services\OrderService\Repository\V1\Tenant\OrderStatusLog\OrderStatusLogRepository as TenantOrderStatusLogRepository;
use App\Services\OrderService\Repository\V1\Driver\Order\OrderInterface as DriverOrderInterface;
use App\Services\OrderService\Repository\V1\Driver\Order\OrderRepository as DriverOrderRepository;
use App\Services\OrderService\Repository\V1\Common\OrderLocation\OrderLocationInterface as CommonOrderLocationInterface;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface as CommonBroadcastOrderInterface;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderRepository as CommonBroadcastOrderRepository;
use App\Services\OrderService\Repository\V1\Common\OrderLocation\OrderLocationRepository as CommonOrderLocationRepository;
use App\Services\OrderService\Repository\V1\Common\OrderItem\OrderItemInterface as CommonOrderItemInterface;
use App\Services\OrderService\Repository\V1\Common\OrderItem\OrderItemRepository as CommonOrderItemRepository;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AdminOrderInterface::class, AdminOrderRepository::class);
        $this->app->bind(AdminOrderStateInterface::class, AdminOrderStateRepository::class);
        $this->app->bind(AdminOrderStatusInterface::class, AdminOrderStatusRepository::class);
        $this->app->bind(CustomerOrderInterface::class, CustomerOrderRepository::class);


        $this->app->bind(TenantOrderStatusLogInterface::class, TenantOrderStatusLogRepository::class);

        $this->app->bind(CommonOrderInterface::class, CommonOrderRepository::class);
        $this->app->bind(CommonOrderItemInterface::class, CommonOrderItemRepository::class);
        $this->app->bind(CommonOrderStatusLogInterface::class, CommonOrderStatusLogRepository::class);
        $this->app->bind(CommonOrderLocationInterface::class, CommonOrderLocationRepository::class);
        $this->app->bind(CommonBroadcastOrderInterface::class, CommonBroadcastOrderRepository::class);
        $this->app->bind(CommonOrderStatusInterface::class, CommonOrderStatusRepository::class);


        $this->app->bind(DriverOrderInterface::class, DriverOrderRepository::class);
        $this->app->bind(DriverOrderStatusInterface::class, DriverOrderStatusRepository::class);
    }

    public function boot(): void
    {
        $this->commands(BroadcastPendingOrdersCommand::class);
        $this->commands(ArchiveBroadcastOrder::class);
        $this->commands(CacheDispatcherDashboardCommand::class);

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/customer.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/tenant.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/driver.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/dispatcher.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->mergeConfigFrom(
            __DIR__ . '/../Configs/V1/Order.php', 'order'
        );
    }
}
