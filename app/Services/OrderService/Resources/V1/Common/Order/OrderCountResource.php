<?php

namespace App\Services\OrderService\Resources\V1\Common\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'status' => $this->lastStatus->only('id', 'name', 'title'),
            'count'  => $this->count
        ];
    }
}
