<?php

namespace App\Services\OrderService\Models;

use App\Services\OrderService\Database\Factories\OrderStatusLogFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $order_id
 * @property integer $order_status_id
 *
 * @property Order $order
 * @property OrderStatus $orderStatus
 */
class OrderStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'order_status_id',
    ];

    protected static function newFactory(): Factory
    {
        return OrderStatusLogFactory::new();
    }

    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}
