<?php

namespace App\Services\AuthorizationService\Database\Seeders;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->each(function ($user) {
            if ($user->driver) {
                $role_ids = [
                    Role::ADMIN->value,
                    Role::DRIVER->value,
                    Role::DISPATCHER->value,
                    Role::TENANT->value,
                    Role::CUSTOMER->value,
                ];
            }
            elseif ($user->username != 'zoot') {
                $role_ids = [
                    Role::ADMIN->value,
                    Role::DISPATCHER->value,
                ];
            }
            else {
                $role_ids = [
                    Role::TENANT->value
                ];
            }

            $user->roles()->sync($role_ids);
        });
    }
}
