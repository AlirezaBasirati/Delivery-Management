<?php

namespace App\Services\PlanningService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property string $name
 * @property Collection<TemplateItem> $items
 */
class Template extends Model
{
    protected $fillable = [
        'id',
        'tenant_id',
        'name',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TemplateItem::class);
    }
}
