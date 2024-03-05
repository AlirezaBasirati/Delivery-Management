<?php

namespace App\Services\FleetService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/driver/v1/driver-locations",
 *     tags={"Driver > Location"},
 *     summary="Store Driver Location",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"latitude", "longitude"},
 *                  example={"latitude": "31.258963" ,"longitude": "51.236547"}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="OK"
 *     )
 * )
 *
 */
class Location
{

}
