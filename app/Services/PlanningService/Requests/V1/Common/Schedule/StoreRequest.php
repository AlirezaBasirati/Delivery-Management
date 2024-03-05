<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tenant_id'       => ['required'],
            'date'            => ['required', 'date:Y-m-d'],
            'timeslot_id'     => ['required', 'exists:timeslots,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'capacity'        => ['numeric'],
            'status'          => ['boolean'],
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
