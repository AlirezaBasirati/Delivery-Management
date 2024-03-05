<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UnAssignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'static_message_id' => ['required', 'exists:static_messages,id']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $order = $this->user()->driver
                    ->assignedOrders()
                    ->where('is_processing', true)
                    ->first();


                if (!$order) {
                    $validator->errors()->add('order', __('messages.no_order_for_driver'));
                }
                elseif ($order->last_status_id == OrderStatus::DONE->value) {
                    $validator->errors()->add('order', __('messages.done_order'));
                }
            }
        ];
    }
}
