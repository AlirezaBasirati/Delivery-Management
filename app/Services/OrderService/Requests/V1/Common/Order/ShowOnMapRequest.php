<?php

namespace App\Services\OrderService\Requests\V1\Common\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ShowOnMapRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Driver $driver */
        $driver = $this->route('driver');

        /** @var Order $vehicle */
        $order = $this->route('order');

        return ($driver->user->tenant_id == auth()->user()->tenant_id) && ($order->tenant_id == auth()->user()->tenant_id);
    }
}
