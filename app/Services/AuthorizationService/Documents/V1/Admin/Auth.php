<?php

namespace App\Services\AuthorizationService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *      path="/api/admin/v1/auth/access",
 *      tags={"Admin > Authorization"},
 *      summary="Get Current User Access",
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 */
class Auth
{

}
