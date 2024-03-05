<?php

namespace App\Services\PlanningService\Documents\V1\Customer;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/customer/v1/schedules/calendar",
 *     tags={"Customer > Schedule"},
 *     summary="calendar",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="from_date", in="query", example="2023-08-10 18:20:30", description="From date",@OA\Schema(type="string")),
 *     @OA\Parameter(name="to_date", in="query", example="2024-02-10 18:20:30", description="From date",@OA\Schema(type="string")),
 *     @OA\Parameter(name="vehicle_type_id", in="query", example="4", description="vehicle type id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *       path="/api/customer/v1/schedules/{schedule}/reserve",
 *       tags={"Customer > Schedule"},
 *       summary="Reserve a Schedule for a Customer",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="schedule", in="path", description="Schedule id", @OA\Schema(type="integer")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example= {
 *                        "first_name": "reyhaneh",
 *                        "last_name": "hosseini",
 *                        "mobile": "09901849202"
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 */
class Schedule
{

}
