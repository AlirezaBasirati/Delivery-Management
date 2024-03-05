<?php

namespace App\Services\CustomerService\Documents\V1\Customer;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *       path="/api/customer/v1/bookmarks",
 *       tags={"Customer > Bookmark"},
 *       summary="Create a Bookmark",
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={"name": "name", "latitude": "latitude", "longitude": "longitude", "address": "address"}
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Get(
 *       path="/api/customer/v1/bookmarks",
 *       tags={"Customer > Bookmark"},
 *       summary="Get Bookmarks list",
 *       security={{"bearerAuth":{}}},
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Get(
 *       path="/api/customer/v1/bookmarks/{id}",
 *       tags={"Customer > Bookmark"},
 *       summary="Find Bookmark by id",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="id",in="path",description="Bookmark id",@OA\Schema(type="integer")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Patch (
 *       path="/api/customer/v1/bookmarks",
 *       tags={"Customer > Bookmark"},
 *       summary="Update Bookmark",
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(required=true,
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(required={},
 *                     example={"name": "name", "latitude": "latitude", "longitude": "longitude", "address": "address"}
 *                 )
 *             )
 *        ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Delete (
 *        path="/api/customer/v1/bookmarks/{id}",
 *        tags={"Customer > Bookmark"},
 *        summary="Delete Bookmark by id",
 *        security={{"bearerAuth":{}}},
 *        @OA\Parameter(name="id",in="path",description="Bookmark id",@OA\Schema(type="integer")),
 *        @OA\Response(
 *            response=200,
 *            description="OK"
 *        )
 *    )
 */
class Bookmark
{

}
