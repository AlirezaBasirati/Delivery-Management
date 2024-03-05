<?php

namespace App\Services\FleetService\Database\Seeders;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Models\Vehicle;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $vehicles = Vehicle::query()
            ->leftJoin('driver_vehicles', 'vehicles.id', 'driver_vehicles.vehicle_id')
            ->whereNull('vehicle_id')
            ->pluck('vehicles.id')
            ->toArray();

        $users = User::query()
            ->where('role_id', Role::DRIVER->value)
            ->get();

        $i = 0;

        /** @var User $user */
        foreach ($users as $user) {
            $driver = Driver::query()->create([
                'user_id' => $user->id,
                'tenant_id' => 1,
                'license_number' => ltrim($user->mobile, '0'),
                'emergency_mobile' => $user->mobile,
                'latitude' => '35.719897',
                'longitude' => '51.339884',
                'status' => 1,
                'is_free' => true
            ]);

            $driver->vehicles()->sync([$vehicles[$i] => ['status' => 1]]);
            $i++;
        }

        Driver::factory()
            ->count(10)
            ->hasAttached(
                Vehicle::factory()->count(1),
                ['status' => true]
            )
            ->create();
    }
}
