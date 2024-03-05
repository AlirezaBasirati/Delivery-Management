<?php

namespace App\Services\FleetService\Repository\V1\Common\Vehicle;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface VehicleInterface extends BaseRepositoryInterface
{
    public function update(Model $model, array $parameters): Model;

    public function destroy(Model $model): bool;

    public function assignDriver(Vehicle $vehicle, Driver $driver, array $parameters): Vehicle;

    public function unAssignDriver(Vehicle $vehicle, Driver $driver): Vehicle;

    public function hasActiveDriver(Vehicle $vehicle): bool;

    public function assignSchedules(Vehicle $vehicle, array $parameters): void;
}
