<?php

namespace App\Services\MessageService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/static-messages",
 *     tags={"Admin > Static Message"},
 *     summary="Create a Static Message",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"group_id", "title", "message"},
 *                  example= {
 *                      "group_id": 1,
 *                      "title": "title",
 *                      "message": "message"
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
 *     path="/api/admin/v1/static-messages",
 *     tags={"Admin > Static Message"},
 *     summary="List all Static Messages",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/static-messages/{static-message}",
 *     tags={"Admin > Static Message"},
 *     summary="Find Static Message by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message", in="path", description="Static Message id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/admin/v1/static-messages/{static-message}",
 *     tags={"Admin > Static Message"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message", in="path", description="Static Message id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "group_id": 1,
 *                       "title": "title",
 *                       "message": "message"
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
 *     path="/api/admin/v1/static-messages/{static-message}",
 *     tags={"Admin > Static Message"},
 *     summary="Delete Static Message by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="static-message", in="path", description="Static Message id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class StaticMessage
{

}
