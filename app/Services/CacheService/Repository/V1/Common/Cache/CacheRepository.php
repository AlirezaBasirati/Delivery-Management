<?php

namespace App\Services\CacheService\Repository\V1\Common\Cache;

use Illuminate\Support\Facades\Cache;

class CacheRepository implements CacheInterface
{
    public function get(string $key, string $driver = null)
    {
        return Cache::driver($driver ?? 'database')->get($key);
    }
}
