<?php

namespace App\Services\FleetService\Models;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Database\Factories\DriverFactory;
use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\OrderService\Models\BroadcastOrder;
use App\Services\OrderService\Models\Order;
use App\Services\TenantService\Models\Tenant;
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
 * @property integer $user_id
 * @property integer $tenant_id
 * @property string $emergency_mobile
 * @property string $license_number
 * @property boolean $status
 * @property boolean $is_free
 * @property string $latitude
 * @property string $longitude
 * @property integer $distance_from_next_location
 * @property integer $duration_to_next_location
 * @property string $type
 *
 * @property Collection $vehicles
 * @property Vehicle $currentVehicle
 * @property User $user
 * @property Tenant $tenant
 * @property Collection<DriverVehicle> $driverVehicles
 */
class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'tenant_id',
        'emergency_mobile',
        'license_number',
        'status',
        'is_free',
        'latitude',
        'longitude',
        'distance_from_next_location',
        'duration_to_next_location',
        'type',
    ];

    protected static function newFactory(): Factory
    {
        return DriverFactory::new();
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, DriverVehicle::class)->withTimestamps();
    }

    public function driverVehicles(): HasMany
    {
        return $this->hasMany(DriverVehicle::class);
    }

    public function getCurrentVehicleAttribute(): ?Vehicle
    {
        return $this->vehicles()
            ->where('driver_vehicles.status', DriverVehicleStatus::Active)
            ->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function broadcastOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BroadcastOrder::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class, BroadcastOrder::class);
    }

    public function getCurrentOrderAttribute(): Model|null
    {
        return $this->assignedOrders()->where('is_processing', true)->first();
    }

    public function assignedOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

}
