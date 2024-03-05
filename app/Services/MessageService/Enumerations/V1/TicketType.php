<?php

namespace App\Services\MessageService\Enumerations\V1;

enum TicketType: string
{
    case ADMIN = 'admin';

    case CUSTOMER = 'customer';

    case DRIVER = 'driver';
}
