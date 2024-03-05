<?php

namespace App\Services\FleetService\Models;

use App\Services\FleetService\Database\Factories\VehicleFactory;
use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\FleetService\Enumerations\V1\VehicleStatus;
use App\Services\PlanningService\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property integer $type_id
 * @property integer $tenant_id
 * @property integer $container_type
 * @property integer $container_height
 * @property integer $container_width
 * @property integer $container_length
 * @property integer $capacity
 * @property string $plate_number
 * @property integer $chassis_number
 * @property integer $construction_year
 * @property double $fuel_consumption_rate
 * @property string $insurance_expire_date
 * @property boolean $status
 *
 * @property Collection<Driver> $drivers
 * @property Collection<DriverVehicle> $driverVehicles
 */
class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'status' => VehicleStatus::class
    ];

    protected $fillable = [
        'id',
        'title',
        'description',
        'icon',
        'type_id',
        'tenant_id',
        'container_type',
        'container_height',
        'container_width',
        'container_length',
        'capacity',
        'plate_number',
        'chassis_number',
        'construction_year',
        'fuel_consumption_rate',
        'insurance_expire_date',
        'status',
    ];

    protected static function newFactory(): Factory
    {
        return VehicleFactory::new();
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, DriverVehicle::class)->withTimestamps();
    }

    public function driverVehicles(): HasMany
    {
        return $this->hasMany(DriverVehicle::class);
    }

    public function getCurrentDriverAttribute(): ?Driver
    {
        return $this->drivers()
            ->where('driver_vehicles.status', DriverVehicleStatus::Active)
            ->first();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'schedule_vehicles');
    }
}
