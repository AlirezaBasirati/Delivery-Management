<?php

namespace App\Services\OrderService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/driver/v1/broadcast-orders/un-assigned-count",
 *     tags={"Driver > Broadcast Order"},
 *     summary="Get un assigned orders count for current user",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class BroadcastOrder
{

}
