<?php

namespace App\Services\AuthenticationService\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $except = $this->route('user')->id;

        return [
            'username'      => ['string'],
            'password'      => ['string', 'nullable'],
            'email'         => ['string', 'unique:users,email,' . $except],
            'mobile'        => ['string', 'unique:users,mobile,' . $except],
            'first_name'    => ['string'],
            'last_name'     => ['string'],
            'national_code' => ['string', 'unique:users,national_code,' . $except],
            'birth_date'    => ['nullable', 'date:Y-m-d'],
            'role'          => ['integer', 'exists:roles,id']

        ];
    }
}
