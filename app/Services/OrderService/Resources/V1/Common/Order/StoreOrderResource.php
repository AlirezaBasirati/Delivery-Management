<?php

namespace App\Services\OrderService\Resources\V1\Common\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
