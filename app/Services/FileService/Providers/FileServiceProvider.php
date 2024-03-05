<?php

namespace App\Services\FileService\Providers;

use App\Services\FileService\Repository\FileServiceInterface;
use App\Services\FileService\Repository\FileServiceRepository;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileServiceInterface::class, FileServiceRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
