<?php

namespace App\Services\PlanningService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property string $starts_at
 * @property string $ends_at
 * @property integer $start
 * @property integer $end
 * @property boolean $status
 * @property string $text
 */
class Timeslot extends Model
{
    protected $fillable = [
        'id',
        'tenant_id',
        'starts_at',
        'ends_at',
        'status',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function getStartAttribute(): int
    {
        return (int)(explode(':',$this->starts_at)[0]);
    }

    public function getEndAttribute(): int
    {
        return (int)(explode(':',$this->ends_at)[0]);
    }

    public function getTextAttribute(): string
    {
        return $this->start . '-' . $this->end;
    }

}
