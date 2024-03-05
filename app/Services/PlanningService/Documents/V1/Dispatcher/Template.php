<?php

namespace App\Services\PlanningService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/templates",
 *     tags={"Dispatcher > Template"},
 *     summary="Create a Template",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={"name", "data"},
 *                  example= {
 *                      "name": "name",
 *                      "items": {
 *                          {
 *                              "day_of_week": 1,
 *                              "timeslot_id": 1,
 *                              "capacity": 50
 *                          },
 *                          {
 *                              "day_of_week": 2,
 *                              "timeslot_id": 1,
 *                              "capacity": 50
 *                          }
 *                      }
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
 *     path="/api/dispatcher/v1/templates",
 *     tags={"Dispatcher > Template"},
 *     summary="List all Templates",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/templates/select",
 *     tags={"Dispatcher > Template"},
 *     summary="List all Templates for Select",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/templates/{template}",
 *     tags={"Dispatcher > Template"},
 *     summary="Find Template by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="template", in="path", description="Template id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/dispatcher/v1/templates/{template}",
 *     tags={"Dispatcher > Template"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="template", in="path", description="Template id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                       "name": "name",
 *                       "items": {
 *                           {
 *                               "day_of_week": 1,
 *                               "timeslot_id": 1,
 *                               "capacity": 50
 *                           },
 *                           {
 *                               "day_of_week": 2,
 *                               "timeslot_id": 1,
 *                               "capacity": 50
 *                           }
 *                       }
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
 *     path="/api/dispatcher/v1/templates/{template}",
 *     tags={"Dispatcher > Template"},
 *     summary="Delete Template by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="template", in="path", description="Template id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Template
{

}
