<?php

namespace App\Services\CustomerService\Documents\V1\Common;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *       path="/api/tenant/v1/customers",
 *       tags={"Tenant > Customer"},
 *       summary="Create a customer",
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={"first_name": "firstname", "last_name": "lastname", "username": "username", "password": "password", "email": "email@email.com", "mobile": "09303522525", "type": "individual", "phone": "02111111111", "address": "address"}
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
 *       path="/api/tenant/v1/customers",
 *       tags={"Tenant > Customer"},
 *       summary="Get Customers list",
 *       security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="created_from", in="query", description="created_from", @OA\Schema(type="string")),
 *      @OA\Parameter(name="created_to", in="query", description="created_to", @OA\Schema(type="string")),
 *      @OA\Parameter(name="type", in="query", description="type", @OA\Schema(type="string")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Get(
 *       path="/api/tenant/v1/customers/{id}",
 *       tags={"Tenant > Customer"},
 *       summary="Find customer by id",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="id",in="path",description="customer id",@OA\Schema(type="integer")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Get(
 *       path="/api/tenant/v1/customers/export",
 *       tags={"Tenant > Customer"},
 *       summary="Export customer list",
 *       security={{"bearerAuth":{}}},
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 **/
class Customer
{

}
