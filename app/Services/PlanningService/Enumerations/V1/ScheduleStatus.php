<?php

namespace App\Services\PlanningService\Enumerations\V1;

enum ScheduleStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
