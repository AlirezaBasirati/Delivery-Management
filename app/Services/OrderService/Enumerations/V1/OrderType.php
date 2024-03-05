<?php

namespace App\Services\OrderService\Enumerations\V1;


enum OrderType: string
{
    case ON_DEMAND = 'on_demand';
    case SCHEDULED = 'scheduled';
}
