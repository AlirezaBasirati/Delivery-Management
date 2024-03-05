<?php

namespace App\Services\OrderService\Enumerations\V1;


enum OrderState: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case UNASSIGNED = 3;
    case DONE = 4;
    case CANCELED = 5;
    case RETURN = 6;
    case NO_DRIVER_FOUND = 7;
}
