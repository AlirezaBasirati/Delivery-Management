<?php

namespace App\Services\FleetService\Repository\V1\Common\VehicleType;

use App\Services\FleetService\Models\VehicleType;
use Celysium\Base\Repository\BaseRepository;

class VehicleTypeRepository extends BaseRepository implements VehicleTypeInterface
{
    public function __construct(VehicleType $model)
    {
        return parent::__construct($model);
    }

}
