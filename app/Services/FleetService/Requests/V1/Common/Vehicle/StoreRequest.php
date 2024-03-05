<?php

namespace App\Services\FleetService\Requests\V1\Common\Vehicle;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'                 => ['nullable', 'string'],
            'description'           => ['nullable', 'string'],
            'icon'                  => ['nullable', 'string'],
            'type_id'               => ['required', 'exists:vehicle_types,id'],
            'tenant_id'             => ['required', 'exists:tenants,id'],
            'container_type'        => ['nullable', 'numeric'],
            'container_height'      => ['nullable', 'numeric'],
            'container_width'       => ['nullable', 'numeric'],
            'container_length'      => ['nullable', 'numeric'],
            'capacity'              => ['nullable', 'numeric'],
            'plate_number'          => ['required', 'string', 'unique:vehicles,plate_number'],
            'chassis_number'        => ['required', 'string'],
            'construction_year'     => ['required', 'numeric'],
            'fuel_consumption_rate' => ['nullable'],
            'insurance_expire_date' => ['required', 'date'],
            'status'                => ['boolean'],
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
