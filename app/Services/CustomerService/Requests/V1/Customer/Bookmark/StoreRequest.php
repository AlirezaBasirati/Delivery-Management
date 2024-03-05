<?php

namespace App\Services\CustomerService\Requests\V1\Customer\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:30'],
            'address'   => ['required', 'string'],
            'latitude'  => ['required', 'gte:-90', 'lte:90'],
            'longitude' => ['required', 'gte:-180', 'lte:180']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
