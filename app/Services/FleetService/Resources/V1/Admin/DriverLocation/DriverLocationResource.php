<?php

namespace App\Services\FleetService\Resources\V1\Admin\DriverLocation;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 *
 */
class DriverLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'vehicle'    => $this->vehicle->only('id', 'title'),
            'driver'     => [
                'id'        => $this->driver_id,
                'full_name' => $this->driver->user->full_name
            ],
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'created_at' => $this->created_at,
        ];
    }
}
