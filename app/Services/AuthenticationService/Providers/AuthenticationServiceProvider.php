<?php

namespace App\Services\AuthenticationService\Providers;

use App\Services\AuthenticationService\Repository\V1\Common\Authentication\AuthenticationRepository as AdminAuthenticationRepository;
use App\Services\AuthenticationService\Repository\V1\Common\Authentication\AuthenticationRepositoryInterface as AdminAuthenticationRepositoryInterface;
use App\Services\AuthenticationService\Repository\V1\Common\Temporary\TemporaryRepository;
use App\Services\AuthenticationService\Repository\V1\Common\Temporary\TemporaryRepositoryInterface;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AdminAuthenticationRepositoryInterface::class, AdminAuthenticationRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);

        $this->app->bind(TemporaryRepositoryInterface::class, TemporaryRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/customer.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/dispatcher.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/driver.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/tenant.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../Language', 'authentication');
    }
}
