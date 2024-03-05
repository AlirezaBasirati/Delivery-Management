<?php

namespace App\Services\FleetService\Providers;

use App\Services\FleetService\Repository\V1\Admin\DriverLocation\DriverLocationInterface as AdminDriverLocationInterface;
use App\Services\FleetService\Repository\V1\Admin\DriverLocation\DriverLocationRepository as AdminDriverLocationRepository;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface as CommonDriverInterface;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverRepository as CommonDriverRepository;
use App\Services\FleetService\Repository\V1\Common\Vehicle\VehicleInterface as CommonVehicleInterface;
use App\Services\FleetService\Repository\V1\Common\Vehicle\VehicleRepository as CommonVehicleRepository;
use App\Services\FleetService\Repository\V1\Common\VehicleType\VehicleTypeInterface as CommonVehicleTypeInterface;
use App\Services\FleetService\Repository\V1\Common\VehicleType\VehicleTypeRepository as CommonVehicleTypeRepository;
use App\Services\FleetService\Repository\V1\Driver\Driver\DriverInterface as DriverDriverInterface;
use App\Services\FleetService\Repository\V1\Driver\Driver\DriverRepository as DriverDriverRepository;
use App\Services\FleetService\Repository\V1\Driver\DriverLocation\DriverLocationInterface as DriverDriverLocationInterface;
use App\Services\FleetService\Repository\V1\Driver\DriverLocation\DriverLocationRepository as DriverDriverLocationRepository;
use Illuminate\Support\ServiceProvider;

class FleetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AdminDriverLocationInterface::class, AdminDriverLocationRepository::class);

        $this->app->bind(CommonDriverInterface::class, CommonDriverRepository::class);
        $this->app->bind(CommonVehicleInterface::class, CommonVehicleRepository::class);
        $this->app->bind(CommonVehicleTypeInterface::class, CommonVehicleTypeRepository::class);

        $this->app->bind(DriverDriverLocationInterface::class, DriverDriverLocationRepository::class);
        $this->app->bind(DriverDriverInterface::class, DriverDriverRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/dispatcher.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/driver.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
