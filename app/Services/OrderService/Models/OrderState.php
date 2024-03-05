<?php

namespace App\Services\OrderService\Models;

use App\Services\OrderService\Database\Factories\OrderStateFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $title
 * @property string $name
 */
class OrderState extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'name'
    ];

    protected static function newFactory(): Factory
    {
        return OrderStateFactory::new();
    }

    public function orderStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderStatus::class, 'state_id');
    }
}
