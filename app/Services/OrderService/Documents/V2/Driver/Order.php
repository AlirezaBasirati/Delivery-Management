<?php

namespace App\Services\OrderService\Documents\V2\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/driver/v2/orders/current",
 *     tags={"Driver > Order"},
 *     summary="Get current order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/driver/v2/orders",
 *     tags={"Driver > Order"},
 *     summary="List all order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="search", in="query", description="search", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Order
{

}
