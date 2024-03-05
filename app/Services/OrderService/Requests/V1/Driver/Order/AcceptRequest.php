<?php

namespace App\Services\OrderService\Requests\V1\Driver\Order;

use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use App\Services\FleetService\Models\DriverVehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AcceptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => ['exists:orders,id']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $driver = $this->user()->driver;

                if (!$driver) {
                    return $validator->errors()->add('driver', __('messages.no_driver_info'));
                }
                else {
                    if (!$driver->status) {
                        return $validator->errors()->add('driver', __('messages.offline_driver'));
                    }

                    if (!$driver->is_free) {
                        return $validator->errors()->add('driver', __('messages.is_not_free'));
                    }

                    $invalid = DriverVehicle::query()
                        ->where('driver_id', $driver->id)
                        ->where('status', DriverVehicleStatus::Active)
                        ->doesntExist();

                    if ($invalid) {
                        return $validator->errors()->add('driver', __('messages.invalid_driver'));
                    }

                    $broadcast_orders = $driver->broadcastOrders()->whereNull('assigned_at');

                    if (isset($this->order_id) && (clone $broadcast_orders)->where('order_id', $this->order_id)->doesntExist()) {
                        return $validator->errors()->add('order_id', __('messages.order_is_not_for_driver'));
                    }

                    $invalid = $broadcast_orders->count() == 0;

                    if ($invalid) {
                        return $validator->errors()->add('driver', __('messages.no_order_for_driver'));
                    }
                }

                return $validator;
            }
        ];
    }
}
