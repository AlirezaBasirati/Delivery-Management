<?php

namespace App\Services\FileService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *      path="/api/admin/v1/files",
 *      tags={"Admin > File"},
 *      summary="Create a user",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  allOf={
 *                      @OA\Schema(
 *                          @OA\Property(
 *                              property="file",
 *                              description="File Items",
 *                              type="string",
 *                              format="binary"
 *                          ),
 *                          @OA\Property(property="description",description="description of file",example="description",type="string"),
 *                      )
 *                  }
 *              )
 *          )
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
