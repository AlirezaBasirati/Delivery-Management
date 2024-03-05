<?php

namespace App\Services\FleetService\Enumerations\V1;


enum DriverType: string
{
    case ON_DEMAND = 'on_demand';
    case SCHEDULED = 'scheduled';
}
