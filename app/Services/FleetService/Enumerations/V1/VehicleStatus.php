<?php

namespace App\Services\FleetService\Enumerations\V1;


enum VehicleStatus: int
{
    case Active = 1;
    case Inactive = 0;
}
