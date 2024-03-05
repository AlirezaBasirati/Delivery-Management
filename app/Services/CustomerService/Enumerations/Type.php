<?php

namespace App\Services\CustomerService\Enumerations;

enum Type: string
{
    case INDIVIDUAL = 'individual';
    case BUSINESS = 'business';

    public static function getCaseValues()
    {
        return array_column(self::cases(), 'value');
    }
}
