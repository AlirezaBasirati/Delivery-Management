<?php

namespace App\Services\PlanningService\Database\Seeders;

use App\Services\PlanningService\Models\Template;
use App\Services\PlanningService\Models\TemplateItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $template_items = [
            [
                'day_of_week' => 0,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 0,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 0,
                'timeslot_id' => 3,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 1,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 1,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 1,
                'timeslot_id' => 3,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 2,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 2,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 2,
                'timeslot_id' => 3,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 3,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 3,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 3,
                'timeslot_id' => 3,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 4,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 4,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 4,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 5,
                'timeslot_id' => 1,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 5,
                'timeslot_id' => 2,
                'capacity'    => 50
            ],
            [
                'day_of_week' => 5,
                'timeslot_id' => 3,
                'capacity'    => 50
            ]
        ];

        TemplateItem::query()->truncate();
        Template::query()->truncate();

        Schema::enableForeignKeyConstraints();

        /** @var Template $template */
        $template = Template::query()->create([
            'tenant_id' => 1,
            'name'      => 'seeder',
        ]);

        foreach ($template_items as $template_item) {
            $template->items()->create($template_item);
        }
    }
}
