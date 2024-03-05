<?php

namespace App\Services\OrderService\Models;

use App\Services\OrderService\Database\Factories\OrderLocationFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $order_id
 * @property double $latitude
 * @property double $longitude
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $postal_code
 * @property integer $type
 * @property integer $sort
 * @property string $delivered_at
 */
class OrderLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'order_id',
        'latitude',
        'longitude',
        'name',
        'address',
        'phone',
        'email',
        'postal_code',
        'type',
        'sort',
        'delivered_at',
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): Factory
    {
        return OrderLocationFactory::new();
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
