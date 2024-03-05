<?php

namespace App\Services\OrderService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/order-statuses",
 *     tags={"Admin > Order Status"},
 *     summary="Create a Order Status",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"group_id", "title", "message"},
 *                  example= {
 *                      "state_id": 1,
 *                      "title": "title",
 *                      "name": "name",
 *                      "sort": 5,
 *                      "code": "501",
 *                      "next_status_id": 5
 *                  }
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/order-statuses",
 *     tags={"Admin > Order Status"},
 *     summary="List all Order Statuses",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/order-statuses/{order-status}",
 *     tags={"Admin > Order Status"},
 *     summary="Find Order Status by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-status", in="path", description="Order Status id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/order-statuses/{order-status}",
 *     tags={"Admin > Order Status"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-status", in="path", description="Order Status id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "state_id": 1,
 *                       "title": "title",
 *                       "name": "name",
 *                       "sort": 5,
 *                       "code": "501",
 *                       "next_status_id": 5
 *                    }
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/v1/order-statuses/{order-status}",
 *     tags={"Admin > Order Status"},
 *     summary="Delete Order Status by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-status", in="path", description="Order Status id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class OrderStatus
{

}
