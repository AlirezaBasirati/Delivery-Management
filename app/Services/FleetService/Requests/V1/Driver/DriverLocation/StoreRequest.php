<?php

namespace App\Services\FleetService\Requests\V1\Driver\DriverLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id'   => ['prohibited'],
            'latitude'  => ['required', 'gte:-90', 'lte:90'],
            'longitude' => ['required', 'gte:-180', 'lte:180']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                $hasVehicle = optional($this->user()->driver)->current_vehicle;

                if (!$hasVehicle) {
                    $validator->errors()->add('vehicle_id', __('messages.no_active_vehicle_for_driver'));
                }
            }
        ];
    }
}
