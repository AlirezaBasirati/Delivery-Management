<?php

namespace App\Services\FleetService\Repository\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role as RoleEnum;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\DriverVehicle;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DriverRepository extends BaseRepository implements DriverInterface
{
    public function __construct(
        Driver                         $model,
        private readonly DriverVehicle $driverVehicle,
        private readonly UserInterface $userService
    )
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'broadcast_order_id' => fn($value) => $query->join('broadcast_orders', 'drivers.id', '=', 'broadcast_orders.driver_id')
                ->where('broadcast_orders.order_id', $value)
                ->select('drivers.*'),
            'status'             => fn($value) => $query->where('drivers.status', $value),
            'is_free'            => '=',
            'has_vehicle'        => fn($value) => $query->join('driver_vehicles', 'drivers.id', '=', 'driver_vehicles.driver_id')
                ->where('driver_vehicles.status', true)
                ->select('drivers.*')
        ];
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $query->where('tenant_id', auth()->user()->tenant_id)
            ->when($parameters['search'] ?? null, function ($query, $search) {
                $query->join('users', 'drivers.user_id', '=', 'users.id')
                    ->where(function ($query) use ($search) {
                        $query->where('users.first_name', 'LIKE', "%$search%")
                            ->orWhere('users.last_name', 'LIKE', "%$search%")
                            ->orWhereRaw("CONCAT_WS(' ', users.first_name, users.last_name) LIKE '%$search%'")
                            ->orWhere('users.national_code', 'LIKE', "%$search%")
                            ->orWhere('users.mobile', 'LIKE', "%$search%");
                    });
            })
            ->select('drivers.*')
            ->distinct('drivers.id');

        return parent::query($query, $parameters);
    }

    public function store(array $parameters): Model
    {
        DB::beginTransaction();

        $parameters['role'] = RoleEnum::DRIVER->value;

        /** @var User $user */
        $user = $this->userService->store($parameters);

        $parameters['user_id'] = $user->id;

        /** @var Driver $model */
        $model = parent::store($parameters);

        if (isset($parameters['vehicle_id'])) {
            $model->vehicles()->syncWithoutDetaching([$parameters['vehicle_id'] => ['status' => true]]);
        }

        DB::commit();

        return $model->refresh();
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        /** @var Driver $model */
        if (isset($parameters['status']) && !$parameters['status'] && $model->status) {
            $this->driverVehicle->query()
                ->where('driver_id', $model->id)
                ->where('status', DriverVehicleStatus::Active)
                ->update([
                    'status' => DriverVehicleStatus::Inactive
                ]);
        }

        $this->userService->update($model->user, $parameters);

        $model = parent::update($model, $parameters);

        if (isset($parameters['vehicle_id'])) {
            $model->vehicles()->syncWithoutDetaching([$parameters['vehicle_id'] => ['status' => true]]);
        }

        DB::commit();

        return $model;
    }

    public function assignVehicle(Driver $driver, $vehicle, array $parameters): Driver
    {
        $driver->vehicles()->syncWithoutDetaching([$vehicle->id => ['status' => $parameters['status']]]);

        return $driver->refresh();
    }

    public function unAssignVehicle(Driver $driver, $vehicle): Driver
    {
        $driver->vehicles()->detach($vehicle->id);

        return $driver->refresh();
    }

    public function destroy(Driver|Model $model): bool
    {
        DB::beginTransaction();

        $model->user->delete();

        $result = parent::destroy($model);

        DB::commit();

        return $result;
    }

    public function map(array $parameters): Collection
    {
        return $this->model->query()
            ->where('tenant_id', auth()->user()->tenant_id)
            ->when($parameters['vehicle_type_id'] ?? null, function ($query, $vehicle_type_id) {
                $query->join('driver_vehicles', 'drivers.id', '=', 'driver_vehicles.driver_id')
                    ->where('driver_vehicles.status', true)
                    ->join('vehicles', 'driver_vehicles.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles.type_id', $vehicle_type_id);
            })
            ->when($parameters['driver_ids'] ?? null, function ($query, $driver_ids) {
                $query->whereIn('drivers.id', $driver_ids);
            })
            ->when(isset($parameters['status']), function ($query) use ($parameters) {
                $query->where('drivers.status', $parameters['status']);
            })
            ->when(isset($parameters['is_free']), function ($query) use ($parameters) {
                $query->where('drivers.is_free', $parameters['is_free']);
            })
            ->with('user')
            ->get();
    }

    public function count(array $parameters): Collection
    {
        return $this->model->query()
            ->where('tenant_id', auth()->user()->tenant_id)
            ->when($parameters['group_by_column'] ?? null, function ($query) use ($parameters) {
                $query->select($parameters['group_by_column'], DB::raw('count(*) as count'))
                    ->groupBy($parameters['group_by_column']);
            }, function ($query) {
                $query->selectRaw('count(*) as count');
            })
            ->get();
    }

    public function hasActiveVehicle(Driver $driver): bool
    {
        return $driver->driverVehicles()
            ->where('status', DriverVehicleStatus::Active)
            ->exists();
    }

    public function nearestQuery(array $parameters, array $conditions = []): Builder
    {
        return $this->model->query()
            ->where($conditions)
            ->selectRaw("drivers.*, st_distance_sphere(POINT(drivers.latitude, drivers.longitude), POINT(" . $parameters['location']['latitude'] . "," . $parameters['location']['longitude'] . ")) as distance")
            ->having('distance', '<=', $parameters['distance'])
            ->orderBy('distance');
    }

    private function getByMobileQuery(string $mobile, array $conditions = []): Builder
    {
        return $this->model->query()
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->where('mobile', $mobile)
            ->where($conditions)
            ->select('drivers.*');
    }

    public function getByMobile(string $mobile, array $conditions = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getByMobileQuery($mobile, $conditions)->get();
    }

    public function checkMobileExists(string $mobile, array $conditions = []): bool
    {
        return $this->getByMobileQuery($mobile, $conditions)->exists();
    }
}
