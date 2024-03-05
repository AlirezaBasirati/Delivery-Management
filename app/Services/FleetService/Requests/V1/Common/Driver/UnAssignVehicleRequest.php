<?php

namespace App\Services\FleetService\Requests\V1\Common\Driver;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;

class UnAssignVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Driver $driver */
        $driver = $this->route('driver');

        /** @var Vehicle $vehicle */
        $vehicle = $this->route('vehicle');

        return ($driver->tenant_id == auth()->user()->tenant_id) && ($vehicle->tenant_id == auth()->user()->tenant_id);
    }
}
