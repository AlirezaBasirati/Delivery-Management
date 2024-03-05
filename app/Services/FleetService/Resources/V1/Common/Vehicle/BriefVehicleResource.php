<?php

namespace App\Services\FleetService\Resources\V1\Common\Vehicle;

use App\Services\FleetService\Resources\V1\Common\VehicleType\VehicleTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property integer $type
 * @property string $plate_number
 * @property integer $chassis_number
 * @property integer $construction_year
 * @property double $fuel_consumption_rate
 * @property string $insurance_expire_date
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 *
 */
class BriefVehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'icon'                  => $this->icon,
            'type'                  => new VehicleTypeResource($this->type),
            'plate_number'          => $this->plate_number,
            'chassis_number'        => $this->chassis_number,
            'construction_year'     => $this->construction_year,
            'fuel_consumption_rate' => $this->fuel_consumption_rate,
            'insurance_expire_date' => $this->insurance_expire_date,
            'status'                => $this->status
        ];
    }
}
