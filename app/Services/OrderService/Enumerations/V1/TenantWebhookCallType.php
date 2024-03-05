<?php

namespace App\Services\OrderService\Enumerations\V1;


enum TenantWebhookCallType: string
{
    case CHANGE_ORDER_STATUS = 'status';
    case RETURN_ORDER = 'return';
}
