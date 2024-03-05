<?php

namespace App\Services\OrderService\Resources\V1\Common\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowDriverOnMapResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'user'      => $this->user->only('id', 'first_name', 'last_name'),
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
