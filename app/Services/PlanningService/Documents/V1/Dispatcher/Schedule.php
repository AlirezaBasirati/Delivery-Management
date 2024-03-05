<?php

namespace App\Services\PlanningService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/schedules/calendar",
 *     tags={"Dispatcher > Schedule"},
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
 *     path="/api/dispatcher/v1/schedules/planning",
 *     tags={"Dispatcher > Schedule"},
 *     summary="calendar",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"name", "data"},
 *                  example= {
 *                      "vehicle_type_id": 1,
 *                      "template_id": 1,
 *                      "from_date": "2024-01-10",
 *                      "to_date": "2024-06-10"
 *                  }
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *      path="/api/dispatcher/v1/schedules",
 *      tags={"Dispatcher > Schedule"},
 *      summary="Create a Schedule",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={"name", "data"},
 *                   example= {
 *                       "date": "2024-01-10",
 *                       "timeslot_id": 1,
 *                       "vehicle_type_id": 1,
 *                       "capacity": 50,
 *                       "vehicles_count": 50,
 *                       "status": 1
 *                   }
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/schedules",
 *      tags={"Dispatcher > Schedule"},
 *      summary="List all Schedules",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="from_date", in="query", example="2023-08-10 18:20:30", description="From date",@OA\Schema(type="string")),
 *      @OA\Parameter(name="to_date", in="query", example="2024-02-10 18:20:30", description="To date",@OA\Schema(type="string")),
 *      @OA\Parameter(name="timeslot_id", in="query", example="1", description="timeslot id",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="vehicle_type_id", in="query", example="1", description="vehicle type id",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/schedules/{schedule}",
 *      tags={"Dispatcher > Schedule"},
 *      summary="Find Schedule by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="schedule", in="path", description="Schedule id", @OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 *
 * @OA\Patch(
 *      path="/api/dispatcher/v1/schedules/{schedule}",
 *      tags={"Dispatcher > Schedule"},
 *      summary="Assign to store",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="schedule", in="path", description="Schedule id", @OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example= {
 *                        "capacity": 50,
 *                        "vehicles_count": 50,
 *                        "status": 1
 *                    }
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Delete(
 *      path="/api/dispatcher/v1/schedules/{schedule}",
 *      tags={"Dispatcher > Schedule"},
 *      summary="Delete Schedule by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="schedule", in="path", description="Schedule id", @OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Post(
 *       path="/api/dispatcher/v1/schedules/{schedule}/assign-vehicles",
 *       tags={"Dispatcher > Schedule"},
 *       summary="Assign Vehicles to Schedules",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="schedule", in="path", description="Schedule id", @OA\Schema(type="integer")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={"name", "data"},
 *                    example= {
 *                        "vehicle_ids": {1,2,3,4}
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
 * @OA\Post(
 *       path="/api/dispatcher/v1/schedules/{schedule}/reserve",
 *       tags={"Dispatcher > Schedule"},
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
