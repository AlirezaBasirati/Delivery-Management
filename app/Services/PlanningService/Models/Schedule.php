<?php

namespace App\Services\PlanningService\Models;

use App\Services\CustomerService\Models\Customer;
use App\Services\FleetService\Models\Vehicle;
use App\Services\FleetService\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property integer $tenant_id
 * @property Carbon $date
 * @property integer $day_of_week
 * @property integer $timeslot_id
 * @property integer $vehicle_type_id
 * @property integer $capacity
 * @property integer $reserved_capacity
 * @property integer $used_capacity
 * @property integer $vehicles_count
 * @property boolean $status
 * @property Timeslot $timeslot
 * @property VehicleType $vehicleType
 * @property Collection<Vehicle> $vehicles
 */
class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'tenant_id',
        'date',
        'day_of_week',
        'timeslot_id',
        'vehicle_type_id',
        'capacity',
        'reserved_capacity',
        'used_capacity',
        'vehicles_count',
        'status',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'schedule_vehicles');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function reserves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReservedSchedule::class);
    }

    public function customerReserves(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'reserved_schedules');
    }

}
