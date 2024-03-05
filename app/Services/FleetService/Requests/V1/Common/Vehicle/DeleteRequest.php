<?php

namespace App\Services\FleetService\Requests\V1\Common\Vehicle;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Vehicle $vehicle */
        $vehicle = $this->route('vehicle');

        return $vehicle->tenant_id == auth()->user()->tenant_id;
    }
}
