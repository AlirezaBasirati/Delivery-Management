<?php

namespace App\Services\AuthenticationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *      path="/api/admin/v1/users",
 *      tags={"Admin > User"},
 *      summary="Create a user",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"username":"reyhoon", "first_name": "Reyhaneh" ,"last_name": "Alihosseini","email": "reyhoon@gmail.com","mobile": "09632587410", "birth_date": "1997-02-12", "password": "pass", "national_code":"1253698745", "status":1, "role": 2}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/admin/v1/users",
 *      tags={"Admin > User"},
 *      summary="List all users",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/admin/v1/users/{id}",
 *      tags={"Admin > User"},
 *      summary="Find user by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="User id",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Patch(
 *      path="/api/admin/v1/users/{id}",
 *      tags={"Admin > User"},
 *      summary="Update User by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="User id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                  example={"username":"reyhoon", "first_name": "Reyhaneh" ,"last_name": "Alihosseini","email": "reyhoon@gmail.com","mobile": "09632587410", "birth_date": "1997-02-12", "password": "pass", "national_code":"1253698745", "status":1, "role": 2}
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
 * @OA\Delete(
 *      path="/api/admin/v1/users/{id}",
 *      tags={"Admin > User"},
 *      summary="Delete User by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="User id",@OA\Schema(type="integer")),
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
