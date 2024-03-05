<?php

namespace App\Services\OrderService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/accept",
 *     tags={"Driver > Order"},
 *     summary="Accept an order",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="order_id",
 *                     type="string",
 *                     description="order id (nullable)",
 *                     example="99a09725-d8b4-4591-8d32-abcb733c765f"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/reorder-locations",
 *     tags={"Driver > Order"},
 *     summary="Reorder locations sort",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(required={},
 *                     example={"items": {{"id": 1}, {"id": 2}}}
 *                 )
 *             )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Get(
 *     path="/api/driver/v1/orders/current",
 *     tags={"Driver > Order"},
 *     summary="Get current order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Get(
 *     path="/api/driver/v1/orders/{order}/select",
 *     tags={"Driver > Order"},
 *     summary="select a scheduled order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Get(
 *     path="/api/driver/v1/orders/current/items",
 *     tags={"Driver > Order"},
 *     summary="Get current order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Get(
 *      path="/api/driver/v1/orders/scheduled-list",
 *      tags={"Driver > Order"},
 *      summary="Get current orders",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *     path="/api/driver/v1/orders",
 *     tags={"Driver > Order"},
 *     summary="List all order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="search", in="query", description="search", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/un-assign",
 *     tags={"Driver > Order"},
 *     summary="Un assign an order",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="static_message_id",
 *                     type="integer",
 *                     description="static message id",
 *                     example=1
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/change-status",
 *     tags={"Driver > Order"},
 *     summary="change current order status",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/return",
 *     tags={"Driver > Order"},
 *     summary="Return order",
 *     security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={
 *                      "type": "partial_return",
 *                      "items": {{"id": 31, "returned_quantity": 1}}
 *                  }
 *               )
 *           )
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/driver/v1/orders/need-support",
 *     tags={"Driver > Order"},
 *     summary="Return order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Order
{

}
