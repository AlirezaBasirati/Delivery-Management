<?php

namespace App\Services\OrderService\Requests\V1\Customer;

use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HurryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');

        /** @var Order $order */
        return $order->customer_id == Auth::user()->customer?->id;
    }

    public function rules(): array
    {
        return [];
    }
}
