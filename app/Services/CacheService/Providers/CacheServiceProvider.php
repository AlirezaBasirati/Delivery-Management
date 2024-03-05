<?php

namespace App\Services\CacheService\Providers;

use App\Services\CacheService\Repository\V1\Common\Cache\CacheInterface;
use App\Services\CacheService\Repository\V1\Common\Cache\CacheRepository;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CacheInterface::class, CacheRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__.'/../Routes/dispatcher.php');
    }
}
