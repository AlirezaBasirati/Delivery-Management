<?php

namespace App\Services\FleetService\Database\Seeders;

use App\Services\FleetService\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Vehicle::factory()
            ->count(20)
            ->create();
    }
}
