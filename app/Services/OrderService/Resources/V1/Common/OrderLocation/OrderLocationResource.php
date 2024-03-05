<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderLocation;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 */
class OrderLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
