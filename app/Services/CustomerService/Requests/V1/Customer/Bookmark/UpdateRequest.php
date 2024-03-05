<?php

namespace App\Services\CustomerService\Requests\V1\Customer\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['string', 'max:30'],
            'address'   => ['string'],
            'latitude'  => ['gte:-90', 'lte:90'],
            'longitude' => ['gte:-180', 'lte:180']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
