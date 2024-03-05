<?php

return [
    'send_with_broadcast' => env('WITH_WEBSOCKET_BROADCAST', false),
    'delivery_time'       => env('ORDER_DELIVERY_TIME', 1000),
    'broadcast'           => [
        'count' => env('BROADCAST_COUNT', 15)
    ],
    'life_time'           => env('ORDER_LIFE_TIME', 15)
];
