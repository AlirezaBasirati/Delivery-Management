<?php

namespace App\Services\MessageService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/static-message-groups",
 *     tags={"Admin > Static Message Group"},
 *     summary="Create a Static Message Group",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"group_id", "title", "message"},
 *                  example= {
 *                      "title": "title",
 *                      "name": "name",
 *                      "parent_id": 1
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
 *     path="/api/admin/v1/static-message-groups",
 *     tags={"Admin > Static Message Group"},
 *     summary="List all Static Message Groups",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/static-message-groups/{static-message-group}",
 *     tags={"Admin > Static Message Group"},
 *     summary="Find Static Message Group by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message-group", in="path", description="Static Message Group ID", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/static-message-groups/{static-message-group}",
 *     tags={"Admin > Static Message Group"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message-group", in="path", description="Static Message Group ID", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "title": "title",
 *                       "name": "name",
 *                       "parent_id": 1
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
 *     path="/api/admin/v1/static-message-groups/{static-message-group}",
 *     tags={"Admin > Static Message Group"},
 *     summary="Delete Static Message Group by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message-group", in="path", description="Static Message Group ID", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class StaticMessageGroup
{

}
