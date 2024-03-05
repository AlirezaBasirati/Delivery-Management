<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use Illuminate\Foundation\Http\FormRequest;

class BulkDispatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_ids'   => ['required_without:driver_id', 'array'],
            'order_ids.*' => ['exists:orders,id'],
            'driver_id'   => ['required_without:order_ids', 'exists:drivers,id']
        ];
    }
}
