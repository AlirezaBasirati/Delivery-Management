<?php

namespace App\Services\FleetService\Requests\V1\Common\Driver;

use App\Services\FleetService\Enumerations\V1\DriverType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $except = $this->route('driver')->user_id;

        return [
            'tenant_id'        => ['prohibited'],
            'username'        => ['prohibited'],
            'password'         => ['string'],
            'first_name'       => ['string', 'max:30'],
            'last_name'        => ['string', 'max:30'],
            'national_code'    => ['string', 'size:10', 'unique:users,national_code,' . $except],
            'mobile'           => ['string', 'size:11', 'unique:users,mobile,' . $except],
            'emergency_number' => ['string'],
            'license_number'   => ['string', 'size:10'],
            'status'           => ['boolean'],
            'is_free'          => ['boolean'],
            'type'             => [Rule::enum(DriverType::class)]
        ];
    }
}
