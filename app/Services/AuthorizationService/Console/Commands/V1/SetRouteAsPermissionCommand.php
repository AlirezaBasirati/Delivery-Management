<?php

namespace App\Services\AuthorizationService\Console\Commands\V1;

use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\AuthorizationService\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class SetRouteAsPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:routes_as_permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            if (!$route->getName()) continue;

            $name = $route->getName();

            /** @var Permission $permission */
            $permission = Permission::query()
                ->whereNotNull('route')
                ->updateOrCreate([
                    'name' => $name,
                ], [
                    'title' => $name,
                    'route' => [
                        'name' => $name,
                        'url' => $route->uri(),
                        'method' => $route->methods
                    ]
                ]);

            $scope = current(explode('.', $name));

            if ($scope == strtolower(Role::ADMIN->name)) {
                $permission->roles()->syncWithoutDetaching([Role::ADMIN->value]);
            }
            elseif ($scope == strtolower(Role::DISPATCHER->name)) {
                $permission->roles()->syncWithoutDetaching([Role::DISPATCHER->value, Role::ADMIN->value]);
            }
            elseif ($scope == strtolower(Role::DRIVER->name)) {
                $permission->roles()->syncWithoutDetaching([Role::DRIVER->value]);
            }
            elseif ($scope == strtolower(Role::CUSTOMER->name)) {
                $permission->roles()->syncWithoutDetaching([Role::CUSTOMER->value]);
            }
            elseif ($scope == strtolower(Role::TENANT->name)) {
                $permission->roles()->syncWithoutDetaching([Role::TENANT->value]);
            }
        }
    }
}
