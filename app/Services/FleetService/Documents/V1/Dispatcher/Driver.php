<?php

namespace App\Services\FleetService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Post(
 *     path="/api/dispatcher/v1/drivers",
 *     tags={"Dispatcher > Driver"},
 *     summary="Create a Driver",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                      "password": "password",
 *                      "first_name": "first name",
 *                      "last_name": "last name",
 *                      "national_code": "1236547890",
 *                      "mobile": "09136551554",
 *                      "emergency_mobile": "09136551554",
 *                      "license_number": "9136551554",
 *                      "type": "scheduled",
 *                      "vehicle_id": 5
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
 *     path="/api/dispatcher/v1/drivers",
 *     tags={"Dispatcher > Driver"},
 *     summary="List all Drivers",
 *     security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="search",in="query",description="search on firstname, lastname, national code and mobile",@OA\Schema(type="string")),
 *      @OA\Parameter(name="status",in="query",description="status",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="is_free",in="query",description="is free",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/dispatcher/v1/drivers/{driver}",
 *     tags={"Dispatcher > Driver"},
 *     summary="Find Driver by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Patch(
 *     path="/api/dispatcher/v1/drivers/{driver}",
 *     tags={"Dispatcher > Driver"},
 *     summary="Assign to store",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={
 *                       "password": "password",
 *                       "first_name": "first name",
 *                       "last_name": "last name",
 *                       "national_code": "1236547890",
 *                       "mobile": "09136551554",
 *                       "emergency_mobile": "09136551554",
 *                       "license_number": "9136551554",
 *                       "status": true,
 *                       "is_free": true,
 *                       "vehicle_id": 5
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
 *     path="/api/dispatcher/v1/drivers/{driver}",
 *     tags={"Dispatcher > Driver"},
 *     summary="Delete Driver by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Post(
 *      path="/api/dispatcher/v1/drivers/{driver}/vehicles/{vehicle}",
 *      tags={"Dispatcher > Driver"},
 *      summary="Create a Driver",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
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
 *      path="/api/dispatcher/v1/drivers/{driver}/vehicles/{vehicle}",
 *      tags={"Dispatcher > Driver"},
 *      summary="Delete Driver by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="driver",in="path",description="Driver id",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="vehicle",in="path",description="Vehicle id",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/drivers/map",
 *      tags={"Dispatcher > Driver"},
 *      summary="List all Drivers",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="driver_ids[]", in="query", description="driver Ids", @OA\Schema(type="array", @OA\Items(type="integer", example="1"))),
 *      @OA\Parameter(name="is_free",in="query",description="is_free",@OA\Schema(type="integer")),
 *      @OA\Parameter(name="status",in="query",description="status",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/drivers/count",
 *      tags={"Dispatcher > Driver"},
 *      summary="List all Drivers",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="group_by_column", in="query", description="group_by_column", @OA\Items(type="string", example="is_free")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/dispatcher/v1/drivers/select",
 *      tags={"Dispatcher > Driver"},
 *      summary="List all Drivers For Select Boxes",
 *      security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="search",in="query",description="search",@OA\Schema(type="string")),
 *       @OA\Parameter(name="has_vehicle",in="query",description="has_vehicle",@OA\Schema(type="integer")),
 *       @OA\Parameter(name="status",in="query",description="status",@OA\Schema(type="integer")),
 *       @OA\Parameter(name="is_free",in="query",description="is_free",@OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Driver
{

}
