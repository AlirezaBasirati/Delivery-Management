<?php

namespace App\Services\PlanningService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/timeslots",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="Create a Timeslot",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"name", "data"},
 *                  example= {
 *                      "starts_at":"08:00:00",
 *                      "ends_at":"09:00:00",
 *                      "status":1
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
 * @OA\Get(
 *     path="/api/dispatcher/v1/timeslots",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="List all Timeslots",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/timeslots/select",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="List all Timeslots for Select",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/timeslots/{timeslot}",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="Find Timeslot by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="timeslot", in="path", description="Timeslot id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/dispatcher/v1/timeslots/{timeslot}",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="timeslot", in="path", description="Timeslot id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                       "starts_at":"08:00:00",
 *                       "ends_at":"09:00:00",
 *                       "status":1
 *                   }
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/dispatcher/v1/timeslots/{timeslot}",
 *     tags={"Dispatcher > Timeslot"},
 *     summary="Delete Timeslot by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="timeslot", in="path", description="Timeslot id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Timeslot
{

}
