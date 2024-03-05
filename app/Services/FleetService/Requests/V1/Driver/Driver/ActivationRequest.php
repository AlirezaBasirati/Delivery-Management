<?php

namespace App\Services\FleetService\Requests\V1\Driver\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ActivationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                $hasVehicle = optional($this->user()->driver)->current_vehicle;

                if (! $hasVehicle) {
                    $validator->errors()->add('vehicle_id', __('messages.no_active_vehicle_for_driver'));
                }
            }
        ];
    }
}
