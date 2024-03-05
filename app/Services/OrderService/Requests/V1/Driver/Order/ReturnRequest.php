<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ReturnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items'                     => ['required_if:type,partial_return', 'array'],
            'items.*.id'                => ['required', 'exists:order_items,id'],
            'items.*.returned_quantity' => ['required', 'numeric'],
            'type'                      => ['required_without:items', 'in:partial_return,full_return,absence_of_receiver']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (in_array($this->type, ['full_return', 'absence_of_receiver']) && isset($this->items)) {
                    $validator->errors()->add('items', __('messages.can_not_select_return_items'));
                }
            }
        ];
    }
}
