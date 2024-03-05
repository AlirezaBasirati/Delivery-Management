<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use Illuminate\Foundation\Http\FormRequest;

class SetLocationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items'      => ['required', 'array'],
            'items.*.id' => ['required', 'exists:order_locations,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
