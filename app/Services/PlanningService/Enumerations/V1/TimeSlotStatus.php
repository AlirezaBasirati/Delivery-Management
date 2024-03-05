<?php

namespace App\Services\PlanningService\Enumerations\V1;

enum TimeSlotStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
