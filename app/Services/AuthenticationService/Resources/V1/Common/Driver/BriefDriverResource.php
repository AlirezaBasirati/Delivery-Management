<?php

namespace App\Services\AuthenticationService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Resources\V1\Common\User\BriefUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $emergency_mobile
 * @property string $license_number
 * @property boolean $status
 * @property User $user
 * @property boolean $is_free
 * @property string $latitude
 * @property string $longitude
 */
class BriefDriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'user'             => new BriefUserResource($this->user),
            'emergency_mobile' => $this->emergency_mobile,
            'license_number'   => $this->license_number,
            'status'           => $this->status,
            'is_free'          => $this->is_free,
            'latitude'         => $this->latitude,
            'longitude'        => $this->longitude,
        ];
    }
}
