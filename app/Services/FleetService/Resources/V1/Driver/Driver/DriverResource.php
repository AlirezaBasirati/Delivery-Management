<?php

namespace App\Services\FleetService\Resources\V1\Driver\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $emergency_mobile
 * @property string $license_number
 * @property boolean $status
 * @property boolean $is_free
 */
class DriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'emergency_mobile' => $this->emergency_mobile,
            'license_number'   => $this->license_number,
            'status'           => $this->status,
            'is_free'          => $this->is_free
        ];
    }
}
