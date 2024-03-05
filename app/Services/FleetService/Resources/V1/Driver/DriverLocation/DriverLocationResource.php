<?php

namespace App\Services\FleetService\Resources\V1\Driver\DriverLocation;

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
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
