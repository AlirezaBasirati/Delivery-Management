<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SelectRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                /** @var Order $order */
                $order = $this->route('order');
                if ($order->driver_id != $this->user()->driver->id || in_array($order->last_status_id, OrderStatus::complete()) || $order->is_processing) {
                    $validator->errors()->add('order', __('messages.can_not_select_order'));
                }
            }
        ];
    }
}
