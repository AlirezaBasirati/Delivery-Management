<?php

namespace App\Services\FleetService\Models;

use App\Services\FleetService\Enumerations\V1\DriverStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property boolean $status
 *
 * @property Driver $driver
 * @property Vehicle $vehicle
 */
class DriverVehicle extends Model
{
    use HasFactory;

    protected $table = 'driver_vehicles';

    protected $fillable = [
        'id',
        'driver_id',
        'vehicle_id',
        'status',
    ];

    protected $casts = [
        'status' => DriverStatus::class
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
