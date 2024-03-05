<?php

namespace App\Services\FleetService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/dispatcher/v1/vehicle-types",
 *     tags={"Dispatcher > Vehicle Type"},
 *     summary="List all Vehicle Types",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class VehicleType
{

}
