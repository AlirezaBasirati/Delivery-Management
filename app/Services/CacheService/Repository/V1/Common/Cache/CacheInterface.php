<?php

namespace App\Services\CacheService\Repository\V1\Common\Cache;

interface CacheInterface
{
    public function get(string $key, string $driver = null);
}
