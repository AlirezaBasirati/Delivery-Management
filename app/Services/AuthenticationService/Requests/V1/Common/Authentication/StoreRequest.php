<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'      => ['required', 'string'],
            'email'         => ['required', 'string'],
            'first_name'    => ['required', 'string', 'max:30'],
            'last_name'     => ['required', 'string', 'max:30'],
            'birth_date'    => ['nullable', 'date:Y-m-d'],
            'national_code' => ['required', 'string', 'unique:users,national_code'],
            'mobile'        => ['required', 'string', 'size:11', 'unique:users,mobile'],
        ];
    }
}
