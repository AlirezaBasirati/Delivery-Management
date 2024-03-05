<?php

namespace App\Services\AuthenticationService\Database\Seeders;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\TenantService\Models\Tenant;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (Role::cases() as $role) {
            $this->createUsers($role);
        }

        User::query()->updateOrCreate([
            'username' => 'zoot',
        ], [
            'email'         => 'zoot@yahoo.com',
            'role_id'       => Role::TENANT->value,
            'tenant_id'     => 1,
            'first_name'    => 'zoot',
            'last_name'     => 'zoot',
            'national_code' => '1234567897',
            'mobile'        => '09120000000',
            'password'      => 'password',
            'birth_date'    => now()->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::factory()
            ->state(['role_id' => Role::DRIVER->value])
            ->count(10)
            ->create();
    }

    public function createUsers($role): void
    {
        $tenant = Tenant::query()
            ->where('name', 'zoot')
            ->first();

        User::query()->updateOrCreate([
            'username' => 'reyhaneh' . '-' . $tenant->id . '-' . $role->value
        ], [
            'email'         => 'reyhaneh@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'reyhaneh',
            'last_name'     => 'hosseini',
            'national_code' => '1234567890',
            'mobile'        => '09901849202',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 1,
        ]);

        User::query()->updateOrCreate([
            'username' => 'zahra' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'zahra@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'zahra',
            'last_name'     => 'hajiali',
            'national_code' => '1234567891',
            'mobile'        => '09127250114',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::query()->updateOrCreate([
            'username' => 'alirezabasirati' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'alirezabasirati@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'علیرضا',
            'last_name'     => 'بصیرتی',
            'national_code' => '1234567892',
            'mobile'        => '09122064144',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::query()->updateOrCreate([
            'username' => 'arminmahdavi' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'arminmahdavi@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'آرمین',
            'last_name'     => 'مهدوی',
            'national_code' => '1234567893',
            'mobile'        => '09126387901',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::query()->updateOrCreate([
            'username' => 'mehrifard' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'mehrifard@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'مهری',
            'last_name'     => 'فرد',
            'national_code' => '1234567894',
            'mobile'        => '09129332638',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::query()->updateOrCreate([
            'username' => 'arsalanarianmehr' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'arsalanarianmehr@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'ارسلان',
            'last_name'     => 'آریان مهر',
            'national_code' => '1234567895',
            'mobile'        => '09217341746',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);

        User::query()->updateOrCreate([
            'username' => 'ebrahimmardani' . '-' . $tenant->id . '-' . $role->value,
        ], [
            'email'         => 'ebrahimmardani@yahoo.com',
            'role_id'       => $role->value,
            'tenant_id'     => $tenant->id,
            'first_name'    => 'ابراهیم',
            'last_name'     => 'مردانی',
            'national_code' => '1234567896',
            'mobile'        => '09127088631',
            'password'      => 'password',
            'birth_date'    => now()->subYears(20)->format('Y-m-d'),
            'status'        => 0,
        ]);
    }
}
