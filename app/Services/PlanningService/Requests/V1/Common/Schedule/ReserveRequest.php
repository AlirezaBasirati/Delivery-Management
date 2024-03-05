<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\AuthenticationService\Models\User;
use App\Services\PlanningService\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ReserveRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Schedule $schedule */
        $schedule = $this->route('schedule');

        return $schedule->tenant_id == auth()->user()->tenant_id;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name'  => ['required', 'string'],
            'mobile'     => ['required', 'string'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                /** @var Schedule $schedule */
                $schedule = $this->route('schedule');

                if (!$schedule->status) {
                    $validator->errors()->add('schedule', __('messages.inactive_schedule'));
                }
            }
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var User $user */
        $user = $this->user();

        $this->merge([
            'tenant_id' => $user->tenant_id
        ]);
    }
}
