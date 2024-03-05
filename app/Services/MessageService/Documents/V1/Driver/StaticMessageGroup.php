<?php

namespace App\Services\MessageService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/driver/v1/static-message-groups",
 *     tags={"Driver > Static Message Group"},
 *     summary="Get Static Message Groups",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="name",in="query",description="name of group",@OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class StaticMessageGroup
{

}
