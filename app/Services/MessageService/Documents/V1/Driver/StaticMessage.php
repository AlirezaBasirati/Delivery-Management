<?php

namespace App\Services\MessageService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/driver/v1/static-messages",
 *     tags={"Driver > Static Message"},
 *     summary="Driver Activation",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="group_id",in="query",description="Group id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class StaticMessage
{

}
