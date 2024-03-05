<?php

namespace App\Services\MessageService\Documents\V1\Customer;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/customer/v1/static-message-groups",
 *     tags={"Customer > Static Message Group"},
 *     summary="Get Static Message Groups",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="name",in="query",description="name of group",@OA\Schema(type="string")),
 *     @OA\Parameter(name="parent_id",in="query",description="id of parent group",@OA\Schema(type="integer")),
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
