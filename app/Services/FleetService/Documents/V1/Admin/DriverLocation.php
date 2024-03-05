<?php

namespace App\Services\FleetService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/admin/v1/driver-locations",
 *     tags={"Admin > Driver Location"},
 *     summary="List all Driver Locations",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="driver_id",in="query",description="Driver id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="from", in="query", example="2023-08-10 18:20:30", description="From time",@OA\Schema(type="date")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class DriverLocation
{

}
