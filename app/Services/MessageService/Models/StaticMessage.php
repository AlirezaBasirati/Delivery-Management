<?php

namespace App\Services\MessageService\Models;

use App\Services\MessageService\Database\Factories\StaticMessageFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $group_id
 * @property string $title
 * @property string $message
 * @property boolean $is_active
 *
 * @property StaticMessageGroup $group

 */
class StaticMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'group_id',
        'title',
        'message',
        'is_active'
    ];

    protected static function newFactory(): Factory
    {
        return StaticMessageFactory::new();
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(StaticMessageGroup::class, 'group_id');
    }
}
