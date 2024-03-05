<?php

namespace App\Services\AuthenticationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/auth/login",
 *     tags={"Admin > Authentication"},
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
 *     path="/api/admin/v1/auth/refresh",
 *     tags={"Admin > Authentication"},
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
 *      path="/api/admin/v1/auth/me",
 *      tags={"Admin > Authentication"},
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
 *      path="/api/admin/v1/auth/me",
 *      tags={"Admin > Authentication"},
 *      summary="Update Current User Info",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"first_name": "f name", "last_name": "l name", "national_code": "1234567890", "mobile": "09901236547", "birth_date": "1997-02-12"}
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
 *      path="/api/admin/v1/auth/change-password",
 *      tags={"Admin > Authentication"},
 *      summary="UChange Password",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={"password": "password", "password_confirmation": "password"}
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
 *      path="/api/admin/v1/auth/logout",
 *      tags={"Admin > Authentication"},
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
