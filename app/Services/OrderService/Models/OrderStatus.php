<?php

namespace App\Services\OrderService\Models;

use App\Services\OrderService\Database\Factories\OrderStatusFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $state_id
 * @property string $code
 * @property string $name
 * @property string $title
 * @property boolean $for_driver
 * @property boolean $reserve
 * @property integer $sort
 *
 * @property OrderStatus $nextStatus
 */
class OrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'state_id',
        'next_status_id',
        'code',
        'name',
        'title',
        'for_driver',
        'sort',
        'reserve',
    ];

    protected static function newFactory(): Factory
    {
        return OrderStatusFactory::new();
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(OrderState::class, 'state_id');
    }

    public function nextStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'next_status_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'last_status_id');
    }
}
