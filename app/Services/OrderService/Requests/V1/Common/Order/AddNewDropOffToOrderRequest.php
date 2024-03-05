<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AddNewDropOffToOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'latitude'        => ['required', 'gte:-90', 'lte:90'],
            'longitude'       => ['required', 'gte:-180', 'lte:180'],
            'first_name'      => ['required', 'string'],
            'last_name'       => ['required', 'string'],
            'address'         => ['required', 'string'],
            'building_number' => ['numeric'],
            'unit'            => ['numeric'],
            'phone'           => ['required', 'string'],
            'email'           => ['nullable', 'string'],
            'postal_code'     => ['nullable', 'string', 'digits:10'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                /** @var Order $order */
                $order = $this->route('order');

                if ($order->type != OrderType::ON_DEMAND->value) {
                    return $validator->errors()->add('order', __('messages.invalid_order_type'));
                }

                return $validator;
            }
        ];
    }
}
