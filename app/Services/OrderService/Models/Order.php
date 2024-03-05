<?php

namespace App\Services\OrderService\Models;

use App\Services\CustomerService\Models\Customer;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use App\Services\OrderService\Database\Factories\OrderFactory;
use App\Services\OrderService\Enumerations\V1\OrderAssignmentPriority;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\PlanningService\Models\Schedule;
use App\Services\TenantService\Models\Tenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property string $id
 * @property string $code
 * @property string $delivery_code
 * @property integer $tenant_id
 * @property integer $customer_id
 * @property string $last_status_id
 * @property double $parcel_value
 * @property integer $price
 * @property string $type
 * @property double $cod_amount
 * @property integer $package_quantity
 * @property integer $schedule_id
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property integer $broadcast_count
 * @property boolean $is_processing
 * @property integer $priority
 * @property array $permissions
 * @property string $last_broadcast_at
 * @property string $start_of_schedule
 *  @property string $note
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Collection<OrderItem> $items
 * @property Driver $driver
 * @property Vehicle $vehicle
 * @property Collection<OrderStatusLog> $statusLogs
 * @property OrderStatus $lastStatus
 * @property OrderStatus $next_status
 * @property Collection<OrderLocation> $pick_ups
 * @property Collection<OrderLocation> $drop_offs
 * @property OrderLocation $current_pick_up
 * @property OrderLocation $current_drop_off
 * @property OrderLocation $last_pick_up
 * @property OrderLocation $last_drop_off
 * @property OrderStatus $orderStatus
 * @property Customer $customer
 * @property Tenant $tenant
 * @property Schedule $schedule
 *
 */
class Order extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'id',
        'code',
        'delivery_code',
        'tenant_id',
        'customer_id',
        'last_status_id',
        'parcel_value',
        'price',
        'type',
        'cod_amount',
        'package_quantity',
        'schedule_id',
        'driver_id',
        'vehicle_id',
        'broadcast_count',
        'last_broadcast_at',
        'is_processing',
        'priority',
        'permissions',
        'start_of_schedule',
        'note',
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    protected $attributes = [
        'permissions' => '{
            "return"         : true,
            "partial_return" : true
        }'
    ];

    protected static function newFactory(): Factory
    {
        return OrderFactory::new();
    }

    protected function priority(): Attribute
    {
        return Attribute::make(
            set: fn($value) => gettype($value) == 'string' ? OrderAssignmentPriority::priority($value) : $value,
        );
    }

    public function lastStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'last_status_id');
    }

    public function getNextStatusAttribute(): ?OrderStatus
    {
        $last_status = $this->lastStatus;
        $next_status = $last_status->nextStatus;

        if (is_null($next_status) && $last_status->id == \App\Services\OrderService\Enumerations\V1\OrderStatus::DONE->value && !is_null($this->current_drop_off)) {
            /** @var OrderStatus $next_status */
            $next_status = OrderStatus::query()->findOrFail(\App\Services\OrderService\Enumerations\V1\OrderStatus::ON_THE_NEXT_WAY->value);
            return $next_status;
        }

        return $next_status;
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(OrderLocation::class);
    }

    public function getPickUpsAttribute(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->locations()
            ->orderBy('sort')
            ->where('type', OrderLocationType::PICK_UP->value)
            ->get();
    }

    public function getDropOffsAttribute(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->locations()
            ->orderBy('sort')
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->get();
    }

    public function getCurrentPickUpAttribute(): ?Model
    {
        return $this->locations()
            ->where('type', OrderLocationType::PICK_UP->value)
            ->whereNull('delivered_at')
            ->orderBy('sort')
            ->first();
    }

    public function getLastPickUpAttribute(): ?Model
    {
        return $this->locations()
            ->where('type', OrderLocationType::PICK_UP->value)
            ->whereNotNull('delivered_at')
            ->latest('sort')
            ->first();
    }

    public function getCurrentDropOffAttribute(): ?Model
    {
        return $this->locations()
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->whereNull('delivered_at')
            ->orderBy('sort')
            ->first();
    }

    public function getLastDropOffAttribute(): ?Model
    {
        return $this->locations()
            ->where('type', OrderLocationType::DROP_OFF->value)
            ->whereNotNull('delivered_at')
            ->latest('sort')
            ->first();
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, BroadcastOrder::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function broadcastOrders(): HasMany
    {
        return $this->hasMany(BroadcastOrder::class);
    }

    public function unAssignedOrders(): HasMany
    {
        return $this->hasMany(UnAssignedOrder::class);
    }
}
