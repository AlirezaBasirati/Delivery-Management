<?php

namespace App\Services\FleetService\Models;

use Illuminate\Database\Eloquent\Model as ModelAlias;
//use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $driver_id
 * @property string $latitude
 * @property string $longitude
 */
class DriverLocation extends Model
{
//    protected $connection = 'mongodb';
//    protected $collection = 'driver_locations';
//
//    public $timestamps = false;

    protected $fillable = [
        'id',
        'vehicle_id',
        'driver_id',
        'latitude',
        'longitude',
        'created_at'
    ];

    public function getVehicleAttribute(): ModelAlias
    {
        return Vehicle::query()->find($this->vehicle_id);
    }

    public function getDriverAttribute(): ModelAlias
    {
        return Driver::query()->find($this->driver_id);
    }
}
