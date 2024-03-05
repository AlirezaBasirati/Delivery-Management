<?php

namespace App\Services\OrderService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/dispatcher/v1/orders",
 *     tags={"Dispatcher > Order"},
 *     summary="Show Orders List",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="created_from", in="query", description="created_from", @OA\Schema(type="string")),
 *     @OA\Parameter(name="created_to", in="query", description="created_to", @OA\Schema(type="string")),
 *     @OA\Parameter(name="search", in="query", description="search", @OA\Schema(type="string")),
 *     @OA\Parameter(name="state_ids[]", in="query", description="state_ids", @OA\Schema(type="array", @OA\Items(type="integer", example="1"))),
 *     @OA\Parameter(name="status_ids[]", in="query", description="status_ids", @OA\Schema(type="array", @OA\Items(type="integer", example="1"))),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/orders/{order}/map",
 *     tags={"Dispatcher > Order"},
 *     summary="Show Order on Map",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/orders/count",
 *     tags={"Dispatcher > Order"},
 *     summary="Get Orders count",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/orders/{order}/assign-driver/{driver}",
 *       tags={"Dispatcher > Order"},
 *       summary="Assign a driver to order and Un Assign previous driver if exists.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\Parameter(name="driver", in="path", description="Driver id", @OA\Schema(type="integer")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "static_message_id":1,
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/orders/{order}/un-assign-driver",
 *       tags={"Dispatcher > Order"},
 *       summary="Un Assign a driver from order and Broadcast Order to Drivers.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "static_message_id":1,
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/orders/{order}/broadcast",
 *       tags={"Dispatcher > Order"},
 *       summary="Broadcast Un Assigned Order to Drivers.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *      path="/api/dispatcher/v1/orders/{order}/cancel",
 *      tags={"Dispatcher > Order"},
 *      summary="Cancel an order",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/order-statuses/orders-count",
 *      tags={"Dispatcher > Order Status"},
 *      summary="Get Orders count per Status",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/orders/assign-driver",
 *       tags={"Dispatcher > Order"},
 *       summary="Bulk assign orders to a driver.",
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "order_ids":{
 *                            "9b2afa08-b691-4010-b837-5110ea717fdd",
 *                            "9b2afcbf-923b-4a16-a287-2e9d2b37f70c"
 *                        },
 *                        "driver_id":1
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/orders/dispatch",
 *       tags={"Dispatcher > Order"},
 *       summary="Bulk dispatch orders",
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "order_ids":{
 *                            "9b2afa08-b691-4010-b837-5110ea717fdd",
 *                            "9b2afcbf-923b-4a16-a287-2e9d2b37f70c"
 *                        },
 *                        "driver_id":1
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 */
class Order
{

}
