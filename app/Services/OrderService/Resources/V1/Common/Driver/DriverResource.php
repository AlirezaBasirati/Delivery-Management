<?php

namespace App\Services\OrderService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Resources\V1\Common\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $emergency_mobile
 * @property boolean $status
 * @property User $user
 */
class DriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'emergency_mobile' => $this->emergency_mobile,
            'status'           => $this->status,
            'user'             => new UserResource($this->user)
        ];
    }
}
