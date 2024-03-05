<?php

namespace App\Services\PlanningService\Database\Seeders;

use App\Services\PlanningService\Models\Schedule;
use App\Services\PlanningService\Models\Template;
use App\Services\PlanningService\Models\TemplateItem;
use App\Services\PlanningService\Repositories\V1\Common\Schedule\ScheduleInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ScheduleSeeder extends Seeder
{
    public function __construct(private readonly ScheduleInterface $scheduleService)
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Schedule::query()->truncate();

        $this->scheduleService->plan([
            'tenant_id'       => 1,
            'template_id'     => 1,
            'from_date'       => '2024-01-01 00:00:00',
            'to_date'         => '2024-12-29 00:00:00',
            'vehicle_type_id' => 1
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
