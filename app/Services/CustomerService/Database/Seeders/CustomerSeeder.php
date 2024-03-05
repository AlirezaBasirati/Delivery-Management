<?php

namespace App\Services\CustomerService\Database\Seeders;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\CustomerService\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::query()
            ->where('role_id', Role::CUSTOMER->value)
            ->get();

        foreach ($users as $user) {
            Customer::query()->create([
                'user_id'   => $user->id,
                'tenant_id' => 1,
                'phone'     => $user->mobile,
            ]);
        }
    }
}
