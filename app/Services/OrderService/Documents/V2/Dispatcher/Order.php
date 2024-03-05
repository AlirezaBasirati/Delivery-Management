<?php

namespace App\Services\OrderService\Documents\V2\Dispatcher;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/dispatcher/v2/orders",
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
 */
class Order
{

}
