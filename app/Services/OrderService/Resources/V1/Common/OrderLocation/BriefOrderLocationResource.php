<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderLocation;

use Illuminate\Http\Resources\Json\JsonResource;

class BriefOrderLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'address'   => $this->address,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
