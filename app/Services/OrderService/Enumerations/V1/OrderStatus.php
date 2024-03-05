<?php

namespace App\Services\OrderService\Enumerations\V1;


enum OrderStatus: int
{
    case PENDING = 1;
    case ASSIGNED = 2;
    case START = 3;
    case PICKING_UP = 4;
    case PICKED_UP = 5;
    case ON_THE_WAY = 6;
    case ON_THE_NEXT_WAY = 7;
    case ARRIVED = 8;
    case DONE = 9;
    case NEED_SUPPORT = 10;
    case UNASSIGNED_BEFORE_PICKED_UP = 11;
    case UNASSIGNED_AFTER_PICKED_UP = 12;
    case CUSTOMER_CANCELED = 13;
    case SUPPORT_CANCELED = 14;
    case PARTIAL_RETURN = 15;
    case COMPLETE_RETURN = 16;
    case ABSENCE_OF_RECEIVER = 17;
    case NO_DRIVER_FOUND = 18;

    public static function complete(): array
    {
        return [
            self::DONE->value,
            self::UNASSIGNED_BEFORE_PICKED_UP->value,
            self::UNASSIGNED_AFTER_PICKED_UP->value,
            self::CUSTOMER_CANCELED->value,
            self::SUPPORT_CANCELED->value,
            self::PARTIAL_RETURN->value,
            self::COMPLETE_RETURN->value,
            self::ABSENCE_OF_RECEIVER->value
        ];
    }
}
