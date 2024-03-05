<?php

namespace App\Services\MessageService\Documents\V1\Driver;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/driver/v1/tickets/{ticket}/messages",
 *     tags={"Driver > Tickets"},
 *     summary="get messages detail of ticket",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="ticket",in="path",description="ticket id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/driver/v1/ticket-messages",
 *     tags={"Driver > Tickets"},
 *     summary="Create a ticket",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"ticket_id": 1, "message": "message"}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

class TicketMessage
{

}
