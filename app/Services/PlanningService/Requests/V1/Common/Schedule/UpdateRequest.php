<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\PlanningService\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tenant_id == $this->route('schedule')->tenant_id;
    }

    public function rules(): array
    {
        return [
            'tenant_id'       => ['prohibited'],
            'date'            => ['prohibited'],
            'timeslot_id'     => ['prohibited'],
            'vehicle_type_id' => ['prohibited'],
            'capacity'        => ['numeric'],
            'vehicles_count'  => ['numeric'],
            'status'          => ['boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                if (isset($this->capacity)) {
                    /** @var Schedule $schedule */
                    $schedule = $this->route('schedule');

                    if ($schedule->reserved_capacity + $schedule->used_capacity > $this->capacity) {
                        $validator->errors()->add('capacity', __('messages.can_not_update_capacity'));
                    }
                }
            }
        ];
    }
}
