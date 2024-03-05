<?php

namespace App\Services\FleetService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Resources\V1\Common\OrderStatus\OrderStatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $emergency_mobile
 * @property User $user
 */
class IndexDriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'user'             => $this->user->only('id', 'first_name', 'last_name', 'mobile'),
            'emergency_mobile' => $this->emergency_mobile,
            'order_status'     => new OrderStatusResource($this->currentOrder?->lastStatus)
        ];
    }
}
