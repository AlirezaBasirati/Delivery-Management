<?php

namespace App\Services\FleetService\Resources\V1\Common\Vehicle;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Resources\V1\Common\Driver\BriefDriverResource;
use App\Services\FleetService\Resources\V1\Common\VehicleType\VehicleTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property integer $type
 * @property integer $container_type
 * @property integer $container_height
 * @property integer $container_width
 * @property integer $container_length
 * @property integer $capacity
 * @property string $plate_number
 * @property integer $chassis_number
 * @property double $fuel_consumption_rate
 * @property string $insurance_expire_date
 * @property boolean $status
 * @property Collection<Driver> $drivers
 * @property string $created_at
 * @property string $updated_at
 *
 */
class VehicleResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = parent::toArray($request);
        $data['type'] = new VehicleTypeResource($this->type);
        $data['driver'] = new BriefDriverResource($this->currentDriver);

        return $data;
    }
}
