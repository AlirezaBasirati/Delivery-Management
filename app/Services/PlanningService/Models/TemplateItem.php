<?php

namespace App\Services\PlanningService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property integer $day_of_week
 * @property integer $timeslot_id
 * @property integer $capacity
 * @property Template $template
 * @property Timeslot $timeslot
 */
class TemplateItem extends Model
{
    protected $fillable = [
        'id',
        'template_id',
        'day_of_week',
        'timeslot_id',
        'capacity'
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }

}
