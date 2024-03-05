<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\OrderService\Enumerations\V1\OrderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tenant_id'                   => ['required'],
            'code'                        => ['string', 'max:30'],
            'parcel_value'                => ['integer'],
            'type'                        => ['required', Rule::enum(OrderType::class)],
            'schedule_id'                 => ['required_if:type,' . OrderType::SCHEDULED->value, 'exists:schedules,id'],
            'priority'                    => ['in:emergency,high,medium,low'],
            'cod_amount'                  => ['integer'],
            'note'                        => ['nullable', 'string'],
            'package_quantity'            => ['numeric'],
            'items'                       => ['array'],
            'items.*.material_code'       => ['required', 'string'],
            'items.*.name'                => ['required', 'string'],
            'items.*.quantity'            => ['required', 'numeric'],
            'items.*.size'                => ['nullable', 'string'],
            'items.*.weight'              => ['nullable', 'numeric'],
            'locations'                   => ['required', 'array'],
            'locations.*.latitude'        => ['required', 'gte:-90', 'lte:90'],
            'locations.*.longitude'       => ['required', 'gte:-180', 'lte:180'],
            'locations.*.name'            => ['required_without:locations.*.last_name', 'string'],
            'locations.*.first_name'      => ['required_without:locations.*.name', 'string'],
            'locations.*.last_name'       => ['required_without:locations.*.name', 'string'],
            'locations.*.address'         => ['required', 'string'],
            'locations.*.building_number' => ['numeric'],
            'locations.*.unit'            => ['numeric'],
            'locations.*.phone'           => ['required', 'string'],
            'locations.*.email'           => ['nullable', 'string'],
            'locations.*.postal_code'     => ['nullable', 'string', 'digits:10'],
            'locations.*.type'            => ['required', 'in:pick_up,drop_off'],
            'locations.*.sort'            => ['numeric'],
            'permissions'                 => ['array'],
            'permissions.*'               => ['boolean'],
            'customer'                    => ['required_without:customer_id', 'array'],
            'customer.first_name'         => ['required_with:customer', 'string'],
            'customer.last_name'          => ['required_with:customer', 'string'],
            'customer.mobile'             => ['required_with:customer', 'string'],
        ];
    }

    public function prepareForValidation(): void
    {
        $user = $this->user();

        if ($user->hasRoles('customer')) {
            $customer = $user->customer;

            $this->merge([
                'tenant_id'   => $customer->tenant?->id,
                'customer_id' => $customer->id
            ]);
        }
        elseif ($user->hasRoles('tenant')) {
            $tenant = $user->tenant;

            $this->merge([
                'tenant_id' => $tenant?->id
            ]);
        }
    }
}
