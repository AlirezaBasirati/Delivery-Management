<?php

namespace App\Services\OrderService\Resources\V1\Driver\OrderLocation;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 */
class OrderLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'name'        => $this->name,
            'address'     => $this->address,
            'phone'       => $this->phone,
            'postal_code' => $this->postal_code,
            'latitude'     => $this->latitude,
            'longitude'    => $this->longitude,
            'delivered_at' => $this->delivered_at,
        ];
    }
}
