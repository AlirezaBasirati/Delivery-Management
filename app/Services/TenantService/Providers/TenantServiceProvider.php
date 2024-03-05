<?php

namespace App\Services\TenantService\Providers;

use App\Services\TenantService\Repository\V1\Common\Tenant\TenantInterface;
use App\Services\TenantService\Repository\V1\Common\Tenant\TenantRepository;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TenantInterface::class, TenantRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
