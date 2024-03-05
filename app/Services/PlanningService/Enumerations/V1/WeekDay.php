<?php

namespace App\Services\PlanningService\Enumerations\V1;

enum WeekDay: int
{
    case SATURDAY = 0;
    case SUNDAY = 1;
    case MONDAY = 2;
    case TUESDAY = 3;
    case WEDNESDAY = 4;
    case THURSDAY = 5;
    case FRIDAY = 6;

    public static function nextDay(WeekDay $day): ?WeekDay
    {
        if ($day->value > 6 || $day->value < 0) {
            return null;
        }

        return $day == WeekDay::FRIDAY ? WeekDay::SATURDAY : self::from($day->value + 1);
    }

    public static function addDays(WeekDay $day, int $n): ?WeekDay
    {
        if ($n > 6 || $n < 0) {
            return null;
        }

        $day_of_week = $day->value + $n;
        if ($day_of_week > 6) $day_of_week -= 7;

        return self::from($day_of_week);
    }
}
