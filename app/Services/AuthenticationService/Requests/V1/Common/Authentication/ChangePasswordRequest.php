<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password'              => ['required', 'confirmed', 'min:6'],
            'password_confirmation' => ['required'],
        ];
    }
}
