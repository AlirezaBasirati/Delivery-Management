<?php

namespace App\Services\NotificationService\Enumerations\V1;


enum NotificationType: string
{
    case MAX_BROADCAST_ORDER = 'max_broadcast_order';
    case UN_ASSIGN_ORDER_BY_DRIVER = 'un_assigned_order_by_driver';
    case ASSIGNED_ORDER = 'assigned_order';
    case PICKED_UP_ORDER = 'picked_up_order';
    case PENDING_ORDERS_COUNT = 'pending_orders_count';
    case PENDING_ORDERS_LIST = 'pending_orders_list';
    case ORDERS = 'orders';
    case UN_ASSIGN_ORDER = 'un_assigned_order';
    case DRIVER_LOCATION = 'driver_location';
    case NO_DRIVER_FOUND = 'no_driver_found';
}
