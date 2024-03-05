<?php

namespace App\Services\AuthenticationService\Documents\V1\Tenant;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/tenant/v1/auth/login",
 *     tags={"Tenant > Authentication"},
 *     summary="Login",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "zoot", "password": "password"}
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
 *     path="/api/tenant/v1/auth/refresh",
 *     tags={"Tenant > Authentication"},
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
 *      path="/api/tenant/v1/auth/me",
 *      tags={"Tenant > Authentication"},
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
 *      path="/api/tenant/v1/auth/change-password",
 *      tags={"Tenant > Authentication"},
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
 *      path="/api/tenant/v1/auth/logout",
 *      tags={"Tenant > Authentication"},
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
