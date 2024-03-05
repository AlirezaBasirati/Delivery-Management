<?php

namespace App\Services\FleetService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/driver/v1/drivers/activation",
 *     tags={"Driver > Driver"},
 *     summary="Driver Activation",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"status": true}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class Driver
{

}
