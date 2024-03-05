<?php

namespace App\Services\FleetService\Repository\V1\Driver\DriverLocation;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\DriverLocation;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DriverLocationRepository extends BaseRepository implements DriverLocationInterface
{
    public function __construct(DriverLocation $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'vehicle_id' => '=',
            'driver_id' => '=',
        ];
    }

    public function store(array $parameters): Model
    {
        if (isset($parameters['user_id'])) {
            $driver = $this->model->query()->where('user_id', $parameters['user_id'])->firstOrFail();
        }
        else {
            /** @var User $user */
            $user = Auth::user();
            $driver = $user->driver;
        }

        $driver->latitude = $parameters['latitude'];
        $driver->longitude = $parameters['longitude'];
        $driver->save();

        $parameters['driver_id'] = $driver->id;
        $parameters['vehicle_id'] = $driver->current_vehicle?->id;

        return parent::store($parameters);
    }
}
