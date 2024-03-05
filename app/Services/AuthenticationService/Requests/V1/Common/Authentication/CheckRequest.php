<?php

namespace App\Services\AuthenticationService\Requests\V1\Common\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required'],
            'otp'      => ['required', 'sometimes'],
            'app'      => ['required', 'string'],
            'key'      => ['string', Rule::requiredIf(function () {
                return in_array($this->app, ['customer', 'driver']);
            })]
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
