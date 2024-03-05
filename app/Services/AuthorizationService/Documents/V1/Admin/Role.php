<?php

namespace App\Services\AuthorizationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/roles",
 *     tags={"Admin > Role"},
 *     summary="Create a Role",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                      "name": "role name",
 *                      "title": "role title",
 *                      "status": true,
 *                      "permissions": {
 *                          "all": false,
 *                          "only": {1, 2, 3, 4, 5},
 *                          "except": {1, 2, 3, 4, 5},
 *                          "append": {1, 2, 3, 4, 5}
 *                      }
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
 *     path="/api/admin/v1/roles",
 *     tags={"Admin > Role"},
 *     summary="List all Roles",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/roles/{role}",
 *     tags={"Admin > Role"},
 *     summary="Find Role by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Role id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/roles/{role}",
 *     tags={"Admin > Role"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="role",in="path",description="Role id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                        "name": "role name",
 *                        "title": "role title",
 *                        "status": true,
 *                        "permissions": {
 *                            "all": false,
 *                            "only": {1, 2, 3, 4, 5},
 *                            "except": {1, 2, 3, 4, 5},
 *                            "append": {1, 2, 3, 4, 5}
 *                        }
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
 *
 * @OA\Patch(
 *     path="/api/admin/v1/roles/{role}/permissions",
 *     tags={"Admin > Role"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="role",in="path",description="Role id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                      "permissions": {
 *                            "all": false,
 *                            "only": {1, 2, 3, 4, 5},
 *                            "except": {1, 2, 3, 4, 5},
 *                            "append": {1, 2, 3, 4, 5}
 *                      }
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
 * @OA\Delete(
 *     path="/api/admin/v1/roles/{role}",
 *     tags={"Admin > Role"},
 *     summary="Delete Role by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="role",in="path",description="Role id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class Role
{

}
