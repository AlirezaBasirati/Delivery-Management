<?php

namespace App\Services\AuthorizationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Patch(
 *      path="/api/admin/v1/users/{user}/roles",
 *      tags={"Admin > User"},
 *      summary="Assign role to user",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="user",in="path",description="User id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"role": 1}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 *
 * @OA\Patch(
 *      path="/api/admin/v1/users/{user}/permissions",
 *      tags={"Admin > User"},
 *      summary="Assign permission to user",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="user",in="path",description="User id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"permissions": {{"id": 1, "is_able": true}, {"id": 2, "is_able": false}}}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Patch(
 *      path="/api/admin/v1/users/{user}/block",
 *      tags={"Admin > User"},
 *      summary="Block Or Unblock user",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="user",in="path",description="User id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"is_blocked": 1}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 */
class User
{

}
