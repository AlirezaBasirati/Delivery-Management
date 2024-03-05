<?php

namespace App\Services\AuthorizationService\Enumerations\V1;


enum Role: int
{
    case ADMIN = 1;
    case DISPATCHER = 2;
    case DRIVER = 3;
    case TENANT = 4;
    case CUSTOMER = 5;

    public static function fromName(string $name)
    {
        return constant("self::$name");
    }
}
