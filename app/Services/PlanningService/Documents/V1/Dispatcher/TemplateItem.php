<?php

namespace App\Services\PlanningService\Documents\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Patch(
 *     path="/api/dispatcher/v1/template_items/{templateItem}",
 *     tags={"Dispatcher > Template Item"},
 *     summary="Update template item",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="templateItem", in="path", description="Template Item id", @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example= {
 *                       "day_of_week": 1,
 *                       "capacity": "50",
 *                       "timeslot_id": 1
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
 *      path="/api/dispatcher/v1/template_items/{templateItem}",
 *      tags={"Dispatcher > Template Item"},
 *      summary="Delete Template by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="templateItem", in="path", description="Template Item id", @OA\Schema(type="integer")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class TemplateItem
{

}
