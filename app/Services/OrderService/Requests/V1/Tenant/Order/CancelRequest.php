<?php

namespace App\Services\OrderService\Requests\V1\Tenant\Order;

use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CancelRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        /** @var Order $order */
        $order = $this->order;

        $tenant_id = $user->tenant?->id;

        return $order->tenant_id == $tenant_id && $order->customer->tenant_id == $tenant_id;
    }

    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                $last_state_id = $this->order->lastStatus->state_id;

                if ($last_state_id == OrderState::CANCELED->value) {
                    return $validator->errors()->add('order', __('messages.order_state_already_is_cancel'));
                }
                elseif ($last_state_id == OrderState::DONE->value) {
                    return $validator->errors()->add('order', __('messages.can_not_cancel_when_order_is_done'));
                }

                return $validator;
            }
        ];
    }

    protected function prepareForValidation(): void
    {
        $order = Order::query()
            ->where('code', $this->route('code'))
            ->whereNotIn('last_status_id', [OrderStatus::CUSTOMER_CANCELED, OrderStatus::SUPPORT_CANCELED])
            ->firstOrFail();

        $this->merge([
            'order' => $order
        ]);
    }
}
