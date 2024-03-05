<?php

namespace App\Services\MessageService\Models;

use App\Services\MessageService\Database\Factories\StaticMessageGroupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $name
 * @property boolean $reserve
 *
 * @property Collection<StaticMessage> $messages
 * @property StaticMessageGroup $parent
 * @property Collection<StaticMessageGroup> $children

 */
class StaticMessageGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'name',
        'reserve'
    ];

    protected static function newFactory(): Factory
    {
        return StaticMessageGroupFactory::class::new();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(StaticMessage::class, 'group_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(StaticMessageGroup::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(StaticMessageGroup::class, 'parent_id');
    }

}
