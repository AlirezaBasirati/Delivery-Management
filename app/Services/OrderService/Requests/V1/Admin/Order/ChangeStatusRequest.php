<?php

namespace App\Services\OrderService\Requests\V1\Admin\Order;

use App\Services\OrderService\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ChangeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status_id' => ['required', 'exists:order_statuses,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
            $order = $this->route('order');

                if (! $order->driver_id) {
                    return $validator->errors()->add('status_id', __('messages.no_driver_for_order'));
                }

                if (! OrderStatus::query()->where('id', $this->status_id)->first()->for_driver) {
                    return $validator->errors()->add('status_id', __('messages.can_not_change_status'));
                }

                if (! $order->is_processing) {
                    return $validator->errors()->add('status_id', __('messages.can_not_change_status'));
                }

                return $validator;
            }
        ];
    }

}
