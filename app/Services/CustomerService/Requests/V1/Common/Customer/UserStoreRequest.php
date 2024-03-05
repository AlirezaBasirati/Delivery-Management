<?php

namespace App\Services\CustomerService\Requests\V1\Common\Customer;

use App\Services\CustomerService\Rules\IranianMobile;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username'   => ['required', 'string', 'unique:users,username'],
            'password'   => ['required', 'string'],
            'first_name' => ['nullable', 'string', 'max:30'],
            'last_name'  => ['nullable', 'string', 'max:30'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'mobile'     => ['required', 'unique:users,mobile', new IranianMobile()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
