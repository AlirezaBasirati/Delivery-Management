<?php

namespace App\Services\OrderService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/order-states",
 *     tags={"Admin > Order State"},
 *     summary="Create a Order State",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"group_id", "title", "message"},
 *                  example= {
 *                      "title": "title",
 *                      "name": "name"
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
 *     path="/api/admin/v1/order-states",
 *     tags={"Admin > Order State"},
 *     summary="List all Order Statees",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/order-states/{order-state}",
 *     tags={"Admin > Order State"},
 *     summary="Find Order State by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-state", in="path", description="Order State id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/order-states/{order-state}",
 *     tags={"Admin > Order State"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-state", in="path", description="Order State id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "title": "title",
 *                       "name": "name"
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
 *     path="/api/admin/v1/order-states/{order-state}",
 *     tags={"Admin > Order State"},
 *     summary="Delete Order State by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order-state", in="path", description="Order State id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class OrderState
{

}
