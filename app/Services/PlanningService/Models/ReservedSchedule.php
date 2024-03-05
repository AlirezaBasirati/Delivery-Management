<?php

namespace App\Services\PlanningService\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $schedule_id
 * @property integer $customer_id
 */
class ReservedSchedule extends Model
{
    protected $fillable = [
        'id',
        'schedule_id',
        'customer_id'
    ];

}
