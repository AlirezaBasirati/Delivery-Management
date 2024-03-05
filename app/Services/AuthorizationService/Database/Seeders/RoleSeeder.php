<?php

namespace App\Services\AuthorizationService\Database\Seeders;

use App\Services\AuthorizationService\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'title'  => 'مدیریت',
                'name'   => 'admin',
                'status' => 1
            ],
            [
                'title'  => 'مدیریت دیسپچر',
                'name'   => 'dispatcher',
                'status' => 1
            ],
            [
                'title'  => 'راننده',
                'name'   => 'driver',
                'status' => 1
            ],
            [
                'title'  => 'تننت',
                'name'   => 'tenant',
                'status' => 1
            ],
            [
                'title'  => 'مشتری',
                'name'   => 'customer',
                'status' => 1
            ]
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
