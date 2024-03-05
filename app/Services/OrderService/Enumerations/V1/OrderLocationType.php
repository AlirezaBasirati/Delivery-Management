<?php

namespace App\Services\OrderService\Enumerations\V1;


enum OrderLocationType: string
{
    case PICK_UP = 'pick_up';
    case DROP_OFF = 'drop_off';
}
