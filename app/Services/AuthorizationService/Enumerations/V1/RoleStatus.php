<?php

namespace App\Services\AuthorizationService\Enumerations\V1;

enum RoleStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
