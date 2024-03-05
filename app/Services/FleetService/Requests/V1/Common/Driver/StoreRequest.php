<?php

namespace App\Services\FleetService\Requests\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\FleetService\Enumerations\V1\DriverType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'         => ['required', 'string', 'max:30', 'unique:users,username'],
            'tenant_id'        => ['required'],
            'first_name'       => ['required', 'string', 'max:30'],
            'last_name'        => ['required', 'string', 'max:30'],
            'national_code'    => ['required', 'string', 'size:10', 'unique:users,national_code'],
            'mobile'           => ['required', 'string', 'size:11', 'unique:users,mobile'],
            'emergency_mobile' => ['required', 'string'],
            'license_number'   => ['required', 'string', 'size:10'],
            'type'             => ['required', Rule::enum(DriverType::class)]
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var User $user */
        $user = $this->user();

        $this->merge([
            'tenant_id' => $user->tenant_id,
            'username'  => $this->post('mobile') . '-' . $user->tenant_id . '-' . Role::DRIVER->value
        ]);
    }
}
