<?php

namespace App\Services\FleetService\Repository\V1\Common\Driver;

use App\Services\FleetService\Models\Driver;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DriverInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function update(Model $model, array $parameters): Model;

    public function assignVehicle(Driver $driver, $vehicle, array $parameters): Driver;

    public function unAssignVehicle(Driver $driver, $vehicle): Driver;

    public function map(array $parameters): Collection;

    public function count(array $parameters): Collection;

    public function hasActiveVehicle(Driver $driver): bool;

    public function nearestQuery(array $parameters, array $conditions = []): Builder;

    public function getByMobile(string $mobile, array $conditions = []);

    public function checkMobileExists(string $mobile, array $conditions = []): bool;
}
