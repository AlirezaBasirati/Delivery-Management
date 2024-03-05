<?php

namespace App\Services\FleetService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/admin/v1/vehicle-types",
 *     tags={"Admin > Vehicle Type"},
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
