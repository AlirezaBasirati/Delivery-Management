<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderStatusLog;

use App\Services\OrderService\Resources\V1\Common\OrderStatus\BriefOrderStatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $emergency_mobile
 * @property boolean $status
 */
class OrderStatusLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'status'     => new BriefOrderStatusResource($this->status),
            'created_at' => $this->created_at
        ];
    }
}
