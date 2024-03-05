<?php

namespace App\Services\AuthenticationService\Documents\V1\Customer;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/customer/v1/auth/check",
 *     tags={"Customer > Authentication"},
 *     summary="Check User For Authentication",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "09901849202", "otp": true, "key": "zoot"}
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
 *     path="/api/customer/v1/auth/verify",
 *     tags={"Customer > Authentication"},
 *     summary="Verify User For Authentication",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "09901849202", "password": "password", "code": "123456", "key": "zoot"}
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
 *     path="/api/customer/v1/auth/forget",
 *     tags={"Customer > Authentication"},
 *     summary="Forget Password",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "09901849202", "key": "zoot"}
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
 *     path="/api/customer/v1/auth/reset",
 *     tags={"Customer > Authentication"},
 *     summary="Reset User Authentication",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"username": "09901849202", "code": "123456"}
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
 *     path="/api/customer/v1/auth/set-password",
 *     tags={"Customer > Authentication"},
 *     summary="Set Password",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"password": "password123", "password_confirmation": "password123", "code": "123456", "key": "zoot"}
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
 * @OA\Get(
 *     path="/api/customer/v1/auth/me",
 *     tags={"Customer > Authentication"},
 *     summary="Get Current User Information",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/customer/v1/auth/me",
 *     tags={"Customer > Authentication"},
 *     summary="Update Current User Info",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"first_name": "f name", "last_name": "l name", "national_code": "1234567890", "emergency_mobile": "09901236547", "birth_date": "1997-02-12"}
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
 *     path="/api/customer/v1/auth/change-password",
 *     tags={"Customer > Authentication"},
 *     summary="UChange Password",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"password": "password", "password_confirmation": "password"}
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
 * @OA\Delete(
 *     path="/api/customer/v1/auth/logout",
 *     tags={"Customer > Authentication"},
 *     summary="Logout Current User",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Auth
{

}
