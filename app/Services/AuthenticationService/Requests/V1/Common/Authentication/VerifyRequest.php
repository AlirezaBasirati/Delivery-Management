<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required'],
            'password' => ['required_without:code', 'string'],
            'code'     => ['required_without:password', 'string'],
            'app'      => ['required', 'string'],
            'key'      => ['required', 'string']
        ];
    }

    protected function prepareForValidation(): void
    {
        $app = \Str::before($this->route()->getName(), '.');

        $this->merge([
            'app' => $app
        ]);
    }
}
