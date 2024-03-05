<?php

namespace App\Services\FleetService\Enumerations\V1;


enum DriverVehicleStatus: int
{
    case Active = 1;
    case Inactive = 0;
}
