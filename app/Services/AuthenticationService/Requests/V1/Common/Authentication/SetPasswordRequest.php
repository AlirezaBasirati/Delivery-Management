<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code'                  => ['required'],
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'app'                   => ['required', 'string'],
            'key'                   => ['required_if:app,customer', 'string']
        ];
    }

    protected function prepareForValidation()
    {
        $app = \Str::before($this->route()->getName(), '.');

        $this->merge([
            'app' => $app
        ]);
    }
}
