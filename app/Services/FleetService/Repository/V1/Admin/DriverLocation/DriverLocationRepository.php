<?php

namespace App\Services\FleetService\Repository\V1\Admin\DriverLocation;

use App\Services\FleetService\Models\DriverLocation;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

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
            'driver_id'  => '=',
            'from'       => fn($value) => $query->whereDate('created_at', '>=', $value)
        ];
    }
}
