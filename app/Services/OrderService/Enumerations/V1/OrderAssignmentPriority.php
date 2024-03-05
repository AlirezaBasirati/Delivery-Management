<?php

namespace App\Services\OrderService\Enumerations\V1;

enum OrderAssignmentPriority: int
{
    case EMERGENCY = 1;
    case HIGH = 2;
    case MEDIUM = 3;
    case LOW = 4;

    public static function priority($name): OrderAssignmentPriority
    {
        return match ($name) {
            'emergency' => self::EMERGENCY,
            'high'      => self::HIGH,
            'medium'    => self::MEDIUM,
            'low'       => self::LOW,
        };
    }
}
