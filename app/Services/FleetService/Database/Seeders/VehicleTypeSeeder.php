<?php

namespace App\Services\FleetService\Database\Seeders;

use App\Services\FleetService\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $vehicle_types = [
            [
                'id' => 1,
                'title' => 'موتور سیکلت'
            ],
            [
                'id' => 2,
                'title' => 'ماشین'
            ],
            [
                'id' => 3,
                'title' => 'کامیون'
            ],
            [
                'id' => 4,
                'title' => 'ون'
            ],
        ];

        VehicleType::query()->truncate();

        Schema::enableForeignKeyConstraints();

        foreach ($vehicle_types as $vehicle_type) {
            VehicleType::query()->create($vehicle_type);
        }
    }
}
