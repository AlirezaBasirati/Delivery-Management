<?php

namespace App\Services\OrderService\Models;

use App\Services\OrderService\Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $material_code
 * @property string $name
 * @property integer $quantity
 * @property integer $returned_quantity
 * @property string $order_id
 * @property string $size
 * @property integer $weight
 *
 */
class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'material_code',
        'name',
        'quantity',
        'returned_quantity',
        'order_id',
        'size',
        'weight',
    ];

    protected static function newFactory(): Factory
    {
        return OrderItemFactory::new();
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
