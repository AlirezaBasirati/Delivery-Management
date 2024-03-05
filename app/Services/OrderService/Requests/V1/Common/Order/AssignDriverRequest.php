<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\DriverVehicle;
use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AssignDriverRequest extends FormRequest
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
            'static_message_id'      => ['exists:static_messages,id'],
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
                $driver = $this->route('driver');
                /** @var Order $order */
                $order = $this->route('order');

                if ($order->type != OrderType::ON_DEMAND->value) {
                    return $validator->errors()->add('order', __('messages.invalid_order_type'));
                }

                if (!$driver->is_free) {
                    return $validator->errors()->add('driver', __('messages.driver_is_not_free'));
                }

                if (!$driver->status) {
                    return $validator->errors()->add('driver', __('messages.driver_is_not_active'));
                }

                $invalid = DriverVehicle::query()
                    ->where('driver_id', $driver->id)
                    ->where('status', DriverVehicleStatus::Active->value)
                    ->doesntExist();

                if ($invalid) {
                    return $validator->errors()->add('driver', __('messages.invalid_driver'));
                }

                if (isset($order->driver_id)) {
                    if ($driver->id == $order->driver_id) {
                        return $validator->errors()->add('driver', __('messages.repetitive', ['attribute' => 'driver']));
                    }

                    if (in_array($order->lastStatus->state_id, [OrderState::DONE->value, OrderState::CANCELED->value])) {
                        return $validator->errors()->add('order', __('messages.can_not_assign'));
                    }

                    // If it has not been picked up yet, then the origin of the order will not change
                    if (is_null($order->current_pick_up) && !isset($this->is_old_driver_location)) {
                        return $validator->errors()->add('is_old_driver_location', __('messages.is_old_driver_location'));
                    }

//                    if ($order->driver_id && !isset($this->static_message_id)) {
//                        return $validator->errors()->add('static_message_id', __('validation.required', ['attribute' => 'static_message_id']));
//                    }
                }

                return $validator;
            }
        ];
    }
}
