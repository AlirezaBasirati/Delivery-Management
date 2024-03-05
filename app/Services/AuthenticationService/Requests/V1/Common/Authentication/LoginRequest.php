<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
