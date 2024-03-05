<?php

namespace App\Services\FleetService\Enumerations\V1;


enum VehicleType: int
{
    case MOTORCYCLE = 1;
    case CAR = 2;
    case TRUCK = 3;
    case VAN = 4;
}
