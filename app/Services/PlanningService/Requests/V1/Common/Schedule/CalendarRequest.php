<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_date'       => ['date:Y-m-d'],
            'to_date'         => ['date:Y-m-d'],
            'vehicle_type_id' => ['exists:vehicle_types,id'],
        ];
    }
}
