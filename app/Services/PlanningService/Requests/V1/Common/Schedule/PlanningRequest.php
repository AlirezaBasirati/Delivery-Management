<?php

namespace App\Services\PlanningService\Requests\V1\Common\Schedule;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PlanningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'template_id'     => ['required', 'exists:templates,id'],
            'tenant_id'       => ['required', 'exists:tenants,id'],
            'from_date'       => ['required', 'date:Y-m-d'],
            'to_date'         => ['required', 'date:Y-m-d', 'after:from_date'],
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
