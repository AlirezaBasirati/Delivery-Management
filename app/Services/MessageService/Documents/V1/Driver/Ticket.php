<?php

namespace App\Services\MessageService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/driver/v1/tickets",
 *     tags={"Driver > Tickets"},
 *     summary="get list of customer tickets",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *
 * @OA\Get(
 *       path="/api/driver/v1/tickets/{ticket}",
 *       tags={"Driver > Tickets"},
 *       summary="get ticket detail",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="ticket",in="path",description="ticket id",@OA\Schema(type="integer")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 * @OA\Post(
 *     path="/api/driver/v1/tickets",
 *     tags={"Driver > Tickets"},
 *     summary="Create a ticket",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"order_id": "9acdc64d-605c-41f6-9456-cfc3ccba0109", "static_message_id": 11, "message": "message"}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Ticket
{

}
