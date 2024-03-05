<?php

namespace App\Services\OrderService\Models;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use App\Services\OrderService\Database\Factories\OrderLocationFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property string $order_id
 * @property string $driver_id
 * @property string $vehicle_id
 * @property integer $broadcast_count
 * @property integer $priority
 * @property string $assigned_at
 */
class BroadcastOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'driver_id',
        'vehicle_id',
        'broadcast_count',
        'priority',
        'assigned_at'
    ];


    protected static function newFactory(): Factory
    {
        return OrderLocationFactory::new();
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
