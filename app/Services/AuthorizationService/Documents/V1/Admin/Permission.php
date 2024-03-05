<?php

namespace App\Services\AuthorizationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/permissions",
 *     tags={"Admin > Permission"},
 *     summary="Create a Permission",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                      "name": "Permission name",
 *                      "title": "Permission title",
 *                      "roles": {1, 2, 3}
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
 *     path="/api/admin/v1/permissions",
 *     tags={"Admin > Permission"},
 *     summary="List all permissions",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/permissions/{permission}",
 *     tags={"Admin > Permission"},
 *     summary="Find Permission by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="permission",in="path",description="Permission id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/permissions/{permission}",
 *     tags={"Admin > Permission"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="permission",in="path",description="Permission id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "name": "Permission name",
 *                       "title": "Permission title",
 *                       "roles": {1, 2, 3}
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
 *     path="/api/admin/v1/permissions/{permission}",
 *     tags={"Admin > Permission"},
 *     summary="Delete Permission by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="permission",in="path",description="Permission id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class Permission
{

}
