<?php

namespace App\Services\FleetService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/vehicles",
 *     tags={"Dispatcher > Vehicle"},
 *     summary="Create a Vehicle",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                      "title": "title",
 *                      "description": "description",
 *                      "icon": "/2023/06/14/417f8b8b-5c45-4f72-b903-0d528a1ab53f.jpg",
 *                      "type_id": 1,
 *                      "container_type": 2,
 *                      "container_height": 20,
 *                      "container_width": 20,
 *                      "container_length": 30,
 *                      "capacity": 300,
 *                      "plate_number": "321k568",
 *                      "chassis_number": "30456658126",
 *                      "construction_year": "1398",
 *                      "fuel_consumption_rate": "20.36",
 *                      "insurance_expire_date": "2023-12-10 00:00:00",
 *                      "status": 1
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
 *     path="/api/dispatcher/v1/vehicles",
 *     tags={"Dispatcher > Vehicle"},
 *     summary="List all Vehicles",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/vehicles/{vehicle}",
 *     tags={"Dispatcher > Vehicle"},
 *     summary="Find Vehicle by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/dispatcher/v1/vehicles/{vehicle}",
 *     tags={"Dispatcher > Vehicle"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "title": "title",
 *                       "description": "description",
 *                       "icon": "/2023/06/14/417f8b8b-5c45-4f72-b903-0d528a1ab53f.jpg",
 *                       "type_id": 1,
 *                       "container_type": 2,
 *                       "container_height": 20,
 *                       "container_width": 20,
 *                       "container_length": 30,
 *                       "capacity": 300,
 *                       "plate_number": "321k568",
 *                       "chassis_number": "30456658126",
 *                       "construction_year": "1398",
 *                       "fuel_consumption_rate": "20.36",
 *                       "insurance_expire_date": "2023-12-10 00:00:00",
 *                       "status": 1
 *                    }
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
 *     path="/api/dispatcher/v1/vehicles/{vehicle}",
 *     tags={"Dispatcher > Vehicle"},
 *     summary="Delete Vehicle by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Post(
 *      path="/api/dispatcher/v1/vehicles/{vehicle}/drivers/{driver}",
 *      tags={"Dispatcher > Vehicle"},
 *      summary="Create a Vehicle",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={
 *                        "status": true
 *                     }
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 *
 * @OA\Delete(
 *      path="/api/dispatcher/v1/vehicles/{vehicle}/drivers/{driver}",
 *      tags={"Dispatcher > Vehicle"},
 *      summary="Delete Vehicle by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *       path="/api/dispatcher/v1/vehicles/select",
 *       tags={"Dispatcher > Vehicle"},
 *       summary="List all Vehicles For Select Boxes",
 *       security={{"bearerAuth":{}}},
 *        @OA\Parameter(name="search",in="query",description="search",@OA\Schema(type="string")),
 *        @OA\Parameter(name="has_driver",in="query",description="has_driver",@OA\Schema(type="integer")),
 *        @OA\Parameter(name="has_free_driver",in="query",description="has_free_driver",@OA\Schema(type="integer")),
 *        @OA\Parameter(name="status",in="query",description="status",@OA\Schema(type="integer")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *      path="/api/dispatcher/v1/vehicles/{vehicle}/assign-schedules",
 *      tags={"Dispatcher > Vehicle"},
 *      summary="Assign Schedules to Vehicle",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   example={
 *                         "schedule_ids": {1,2,3,4}
 *                     }
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Vehicle
{

}
