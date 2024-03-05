<?php

namespace App\Services\FleetService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property User $user
 * @property string $emergency_mobile
 * @property Vehicle $currentVehicle
 */
class SelectDriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'user'             => $this->user->only('id', 'first_name', 'last_name'),
            'emergency_mobile' => $this->emergency_mobile,
            'vehicle'          => $this->currentVehicle?->only('id', 'title')
        ];
    }
}
