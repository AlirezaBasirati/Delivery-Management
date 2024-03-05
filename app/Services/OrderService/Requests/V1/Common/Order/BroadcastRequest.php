<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BroadcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Driver $driver */
        $driver = $this->route('driver');

        /** @var Order $vehicle */
        $order = $this->route('order');

        return ($driver->user->tenant_id == auth()->user()->tenant_id) && ($order->tenant_id == auth()->user()->tenant_id);
    }

    public function rules(): array
    {
        return [
            'is_old_driver_location' => ['nullable', 'boolean'],
            'pick_up'                => ['required_if:is_old_driver_location,0', 'array'],
            'pick_up.latitude'       => ['required_if:is_old_driver_location,0', 'gte:-90', 'lte:90'],
            'pick_up.longitude'      => ['required_if:is_old_driver_location,0', 'gte:-180', 'lte:180'],
            'pick_up.name'           => ['required_if:is_old_driver_location,0', 'string'],
            'pick_up.postal_code'    => ['string', 'digits:10'],
            'pick_up.address'        => ['required_if:is_old_driver_location,0', 'string'],
            'pick_up.phone'          => ['required_if:is_old_driver_location,0', 'string'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $order = $this->route('order');
                if ($order->type != OrderType::ON_DEMAND->value) {
                    return $validator->errors()->add('order', __('messages.invalid_order_type'));
                }

                $last_status = $order->lastStatus;

                if ($last_status->state_id != OrderState::UNASSIGNED->value) {
                    return $validator->errors()->add('order', __('messages.last_status_of_order_must_be_un_assigned'));
                }

                // If it has not been picked up yet, then the origin of the order will not change
                if ($last_status->id == OrderStatus::UNASSIGNED_AFTER_PICKED_UP->value && (!isset($this->is_old_driver_location))) {
                    return $validator->errors()->add('is_old_driver_location', __('messages.is_old_driver_location'));
                }

                return $validator;
            }
        ];
    }
}
