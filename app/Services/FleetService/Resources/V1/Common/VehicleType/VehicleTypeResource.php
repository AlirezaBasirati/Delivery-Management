<?php

namespace App\Services\FleetService\Resources\V1\Common\VehicleType;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 *
 */
class VehicleTypeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
        ];
    }
}
