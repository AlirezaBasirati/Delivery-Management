<?php

namespace App\Services\OrderService\Models;

use App\Services\FleetService\Models\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property string $order_id
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property integer $static_message_id
 * @property integer $last_status_log_id
 */
class UnAssignedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'driver_id',
        'vehicle_id',
        'static_message_id',
        'last_status_log_id',
        'static_message_id'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function statusLog(): BelongsTo
    {
        return $this->belongsTo(OrderStatusLog::class, 'last_status_log_id');
    }
}
