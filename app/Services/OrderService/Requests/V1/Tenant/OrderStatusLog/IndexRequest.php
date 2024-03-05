<?php

namespace App\Services\OrderService\Requests\V1\Tenant\OrderStatusLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                // todo If the users role is customer, then they can only see them own orders
            }
        ];
    }
}
