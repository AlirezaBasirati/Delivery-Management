<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'         => ['prohibited'],
            'password'         => ['prohibited'],
            'email'            => ['string', 'unique:users,email'],
            'first_name'       => ['string', 'max:30'],
            'last_name'        => ['string', 'max:30'],
            'national_code'    => ['string'],
            'mobile'           => ['string', 'size:11'],
            'birth_date'       => ['date:Y-m-d'],
            'emergency_mobile' => ['string', 'size:11'],
        ];
    }
}
