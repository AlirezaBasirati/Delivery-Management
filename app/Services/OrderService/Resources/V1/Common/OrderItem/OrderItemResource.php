<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderItem;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 */
class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
