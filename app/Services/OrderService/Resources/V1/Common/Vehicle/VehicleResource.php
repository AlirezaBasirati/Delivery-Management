<?php

namespace App\Services\OrderService\Resources\V1\Common\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $plate_number
 * @property integer $chassis_number
 *
 */
class VehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'plate_number'   => $this->plate_number,
            'chassis_number' => $this->chassis_number,
        ];
    }
}
