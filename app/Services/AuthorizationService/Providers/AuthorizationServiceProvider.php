<?php

namespace App\Services\AuthorizationService\Providers;

use App\Services\AuthorizationService\Console\Commands\V1\SetRouteAsPermissionCommand;
use App\Services\AuthorizationService\Middlewares\CheckPermission;
use App\Services\AuthorizationService\Middlewares\CheckRole;
use App\Services\AuthorizationService\Middlewares\CheckRoutePermission;
use App\Services\AuthorizationService\Middlewares\CheckUserBlock;
use App\Services\AuthorizationService\Models\Permission;
use App\Services\AuthorizationService\Models\Role;
use App\Services\AuthorizationService\Observers\PermissionObserver;
use App\Services\AuthorizationService\Observers\RoleObserver;
use App\Services\AuthorizationService\Repository\V1\Admin\Authorization\AuthorizationRepository;
use App\Services\AuthorizationService\Repository\V1\Admin\Authorization\AuthorizationInterface;
use App\Services\AuthorizationService\Repository\V1\Admin\Permission\PermissionInterface;
use App\Services\AuthorizationService\Repository\V1\Admin\Permission\PermissionRepository;
use App\Services\AuthorizationService\Repository\V1\Admin\Role\RoleInterface;
use App\Services\AuthorizationService\Repository\V1\Admin\Role\RoleRepository;
use App\Services\AuthorizationService\Repository\V1\Admin\User\UserRepository;
use App\Services\AuthorizationService\Repository\V1\Admin\User\UserInterface;
use App\Services\AuthorizationService\Traits\V1\Permissions;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(AuthorizationInterface::class, AuthorizationRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);


        $this->registerObservers();
    }

    public function boot(): void
    {
        $this->loadCommands();

        $this->loadRoutes();

        $this->loadMigrations();

        $this->registerMiddlewares();

        $this->registerGates();
    }

    public function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
    }

    public function loadCommands(): void
    {
        $this->commands(SetRouteAsPermissionCommand::class);
    }

    public function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function registerMiddlewares(): void
    {
        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('permission', CheckPermission::class);
        $router->aliasMiddleware('role', CheckRole::class);
        $router->aliasMiddleware('check-permissions', CheckRoutePermission::class);
        $router->aliasMiddleware('check-user-block', CheckUserBlock::class);

        $router->pushMiddlewareToGroup('api', 'check-permissions');
        $router->pushMiddlewareToGroup('api', 'check-user-block');
    }

    protected function registerGates(): void
    {
        Gate::define('role', function ($user, string $role) {
            /** @var Permissions $user */
            return $user->hasRoles($role);
        });

        Gate::define('permission', function ($user, string $permission) {
            /** @var Permissions $user */
            return $user->hasPermissions($permission);
        });
    }

    public function registerObservers(): void
    {
        $this->booting(function () {
            Permission::observe([PermissionObserver::class]);
            Role::observe([RoleObserver::class]);
        });
    }
}
