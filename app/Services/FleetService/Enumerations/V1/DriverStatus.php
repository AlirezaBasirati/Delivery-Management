<?php

namespace App\Services\FleetService\Enumerations\V1;


enum DriverStatus: int
{
    case Active = 1;
    case Inactive = 0;
}
