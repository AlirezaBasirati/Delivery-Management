<?php

namespace App\Services\CacheService\Document\V1\Dispatcher;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/dispatcher/v1/cache/{key}",
 *      tags={"Dispatcher > Cache"},
 *      summary="get cache data by key",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="key",in="path",description="key",@OA\Schema(type="string")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Cache
{

}
