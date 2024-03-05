<?php

namespace App\Services\OrderService\Resources\V1\Tenant\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $latitude
 * @property string $longitude
 */
class DriverLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
