<?php

namespace App\Services\FleetService\Resources\V1\Common\Vehicle;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\VehicleType;
use App\Services\FleetService\Resources\V1\Common\VehicleType\VehicleTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $plate_number
 * @property VehicleType $type
 * @property Driver $currentDriver
 *
 */
class SelectVehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        $driver = $this->currentDriver;

        return [
            'id'           => $this->id,
            'type'         => new VehicleTypeResource($this->type),
            'title'        => $this->title,
            'plate_number' => $this->plate_number,
            'driver'       => $driver ? [
                'id'   => $driver->id,
                'user' => $driver->user->only('id', 'first_name', 'last_name')
            ] : null
        ];
    }
}
