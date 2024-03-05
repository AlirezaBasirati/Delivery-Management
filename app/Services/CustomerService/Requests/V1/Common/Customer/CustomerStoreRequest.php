<?php

namespace App\Services\CustomerService\Requests\V1\Common\Customer;

use App\Services\CustomerService\Enumerations\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CustomerStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'    => ['required', new Enum(Type::class)],
            'phone'   => ['string', Rule::requiredIf(request('type') == Type::BUSINESS->value)],
            'address' => ['string', Rule::requiredIf(request('type') == Type::BUSINESS->value)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
