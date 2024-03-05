<?php

namespace App\Services\CacheService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\CacheService\Repository\V1\Common\Cache\CacheInterface;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function __construct(
        private readonly CacheInterface $cacheService,
    )
    {
    }

    public function get(Request $request, string $key): JsonResponse
    {
        $cache = $this->cacheService->get($key, 'database');

        return Responser::success($cache ?? []);
    }
}
