<?php

namespace App\Services\AuthenticationService\Enumerations\V1;


enum AppType: string
{
    case DRIVER = 'driver';
    case CUSTOMER = 'customer';
}
