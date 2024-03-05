<?php

namespace App\Services\FleetService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Resources\V1\Common\User\BriefUserResource;
use App\Services\FleetService\Resources\V1\Common\Vehicle\BriefVehicleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Driver $this */
        return [
            'id'               => $this->id,
            'user'             => new BriefUserResource($this->user),
            'emergency_mobile' => $this->emergency_mobile,
            'license_number'   => $this->license_number,
            'status'           => $this->status,
            'is_free'          => $this->is_free,
            'latitude'         => $this->latitude,
            'longitude'        => $this->longitude,
            'type'             => $this->type,
            'vehicle'          => new BriefVehicleResource($this->currentVehicle)
        ];
    }
}
