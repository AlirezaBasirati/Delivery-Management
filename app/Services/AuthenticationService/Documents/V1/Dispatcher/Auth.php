<?php

namespace App\Services\AuthenticationService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/auth/login",
 *     tags={"Dispatcher > Authentication"},
 *     summary="Login",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "09901849202", "password": "password"}
 *              )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/auth/refresh",
 *     tags={"Dispatcher > Authentication"},
 *     summary="Refresh token",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"refresh_token": "refresh_token"}
 *              )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/auth/me",
 *      tags={"Dispatcher > Authentication"},
 *      summary="Get Current User Information",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 *
 * @OA\Patch(
 *      path="/api/dispatcher/v1/auth/me",
 *      tags={"Dispatcher > Authentication"},
 *      summary="Update Current User Info",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"first_name": "f name", "last_name": "l name", "national_code": "1234567890", "birth_date": "1997-02-12"}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Delete(
 *      path="/api/dispatcher/v1/auth/logout",
 *      tags={"Dispatcher > Authentication"},
 *      summary="Logout Current User",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Auth
{

}
