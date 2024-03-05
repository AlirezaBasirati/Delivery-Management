<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use Illuminate\Foundation\Http\FormRequest;

class BulkAssignDriverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_ids'   => ['required', 'array'],
            'order_ids.*' => ['required', 'exists:orders,id'],
            'driver_id'   => ['required', 'exists:drivers,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tenant_id' => $this->user()->tenant_id
        ]);
    }
}
