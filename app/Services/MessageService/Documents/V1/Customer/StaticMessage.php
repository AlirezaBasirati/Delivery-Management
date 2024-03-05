<?php

namespace App\Services\MessageService\Documents\V1\Customer;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/customer/v1/static-messages",
 *     tags={"Customer > Static Message"},
 *     summary="Static Messages",
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
