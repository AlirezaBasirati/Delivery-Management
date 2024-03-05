<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\PlanningService\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tenant_id == $this->route('schedule')->tenant_id;
    }

    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                /** @var Schedule $schedule */
                $schedule = $this->route('schedule');

                if ($schedule->reserved_capacity || $schedule->used_capacity) {
                    $validator->errors()->add('capacity', __('messages.can_not_delete_capacity'));
                }
            }
        ];
    }
}
