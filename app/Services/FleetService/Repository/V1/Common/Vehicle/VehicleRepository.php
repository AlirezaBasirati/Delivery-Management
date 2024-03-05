<?php

namespace App\Services\FleetService\Repository\V1\Common\Vehicle;

use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\DriverVehicle;
use App\Services\FleetService\Models\Vehicle;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VehicleRepository extends BaseRepository implements VehicleInterface
{
    public function __construct(Vehicle $model, private readonly DriverVehicle $driverVehicle)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'type_id'                    => '=',
            'status'                     => fn($value) => $query->where('vehicles.status', $value),
            'title'                      => fn($value) => $query->where('title', 'LIKE', "%$value%"),
            'plate_number'               => fn($value) => $query->where('plate_number', 'LIKE', "%$value%"),
            'chassis_number'             => fn($value) => $query->where('chassis_number', 'LIKE', "%$value%"),
            'construction_year'          => fn($value) => $query->where('construction_year', 'LIKE', "%$value%"),
            'insurance_expire_date_from' => fn($value) => $query->where('insurance_expire_date', '>=', $value),
            'insurance_expire_date_to'   => fn($value) => $query->where('insurance_expire_date', '<=', $value)
        ];
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $query->where('tenant_id', auth()->user()->tenant_id)
            ->when($parameters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('plate_number', 'LIKE', "%$search%");
                });
            })
            ->when(isset($parameters['has_driver']) || isset($parameters['has_free_driver']), function ($query) use ($parameters) {
                $query->join('driver_vehicles', 'vehicles.id', '=', 'driver_vehicles.vehicle_id')
                    ->where('driver_vehicles.status', true)
                    ->when($parameters['has_free_driver'] ?? null, function ($query, $has_free_driver) {
                        $query->join('drivers', 'driver_vehicles.driver_id', '=', 'drivers.id')
                            ->where('drivers.is_free', $has_free_driver)
                            ->where('drivers.status', true);
                    });
            })
            ->select('vehicles.*')
            ->distinct('vehicles.id');

        return parent::query($query, $parameters);
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        $model = parent::update($model, $parameters);

        if (isset($parameters['status']) && !$parameters['status'] && $model->status) {
            $this->driverVehicle->query()
                ->where('vehicle_id', $model->id)
                ->where('status', DriverVehicleStatus::Active)
                ->update([
                    'status' => DriverVehicleStatus::Inactive->value
                ]);
        }

        DB::commit();

        return $model;
    }

    public function destroy(Model $model): bool
    {
        DB::beginTransaction();

        $model->drivers()->detach();

        $result = parent::destroy($model);

        DB::commit();

        return $result;
    }

    public function assignDriver(Vehicle $vehicle, Driver $driver, array $parameters): Vehicle
    {
        $vehicle->drivers()->syncWithoutDetaching([$driver->id => ['status' => $parameters['status']]]);

        return $vehicle->refresh();
    }

    public function unAssignDriver(Vehicle $vehicle, Driver $driver): Vehicle
    {
        $vehicle->drivers()->detach($driver->id);

        return $vehicle->refresh();
    }

    public function hasActiveDriver(Vehicle $vehicle): bool
    {
        return $vehicle->driverVehicles()
            ->where('status', DriverVehicleStatus::Active)
            ->exists();
    }

    public function assignSchedules(Vehicle $vehicle, array $parameters): void
    {
        $vehicle->schedules()->syncWithoutDetaching($parameters['schedule_ids']);
    }
}
