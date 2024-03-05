<?php

namespace App\Services\AuthenticationService\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'      => ['required', 'string', 'unique:users,username'],
            'email'         => ['required_without:mobile', 'string', 'unique:users,email'],
            'mobile'        => ['required', 'string', 'unique:users,mobile'],
            'first_name'    => ['required', 'string'],
            'last_name'     => ['required', 'string'],
            'national_code' => ['required', 'string', 'unique:users,national_code'],
            'password'      => ['required', 'sometimes', 'string'],
            'birth_date'    => ['nullable', 'date:Y-m-d'],
            'role'          => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
