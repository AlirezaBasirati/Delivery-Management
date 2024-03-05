<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CancelRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();
        /** @var Order $order */
        $order = $this->route('order');

        if ($user->hasRoles('tenant')) {
            $tenant = $user->tenant;

            return $order->tenant_id == $tenant->id && $order->customer->tenant_id == $tenant->id;
        }
        elseif ($user->hasRoles('customer')) {
            return $order->customer_id == $user->customer->id;
        }
        elseif ($user->hasRoles('admin')) {
            return true;
        }
        return $order->tenant_id == auth()->user()->tenant_id;
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
}
