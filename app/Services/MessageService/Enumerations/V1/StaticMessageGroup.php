<?php

namespace App\Services\MessageService\Enumerations\V1;


enum StaticMessageGroup: int
{
    case UN_ASSIGN_DRIVER = 1;
    case NEED_TO_SUPPORT_TO_COMPLETE_ORDER = 2;
}
