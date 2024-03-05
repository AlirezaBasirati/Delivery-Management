<?php

namespace App\Services\PlanningService\Database\Seeders;

use App\Services\PlanningService\Enumerations\V1\TimeSlotStatus;
use App\Services\PlanningService\Models\Timeslot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $timeslots = [
            [
                'id'        => 1,
                'tenant_id' => 1,
                'starts_at' => '08:00:00',
                'ends_at'   => '12:00:00',
                'status'    => TimeSlotStatus::ACTIVE->value,
            ],
            [
                'id'        => 2,
                'tenant_id' => 1,
                'starts_at' => '12:00:00',
                'ends_at'   => '16:00:00',
                'status'    => TimeSlotStatus::ACTIVE->value,
            ],
            [
                'id'        => 3,
                'tenant_id' => 1,
                'starts_at' => '16:00:00',
                'ends_at'   => '20:00:00',
                'status'    => TimeSlotStatus::ACTIVE->value,
            ]
        ];

        Timeslot::query()->truncate();

        Schema::enableForeignKeyConstraints();

        foreach ($timeslots as $timeslot) {
            Timeslot::query()->create($timeslot);
        }
    }
}
