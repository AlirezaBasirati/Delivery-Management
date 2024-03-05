<?php

namespace App\Services\FleetService\Requests\V1\Common\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tenant_id'             => ['prohibited'],
            'title'                 => ['string'],
            'description'           => ['string'],
            'icon'                  => ['string'],
            'type_id'               => ['exists:vehicle_types,id'],
            'container_type'        => ['numeric'],
            'container_height'      => ['numeric'],
            'container_width'       => ['numeric'],
            'container_length'      => ['numeric'],
            'capacity'              => ['numeric'],
            'plate_number'          => ['string'],
            'chassis_number'        => ['string'],
            'construction_year'     => ['numeric'],
            'insurance_expire_date' => ['date'],
            'status'                => ['boolean'],
        ];
    }
}
