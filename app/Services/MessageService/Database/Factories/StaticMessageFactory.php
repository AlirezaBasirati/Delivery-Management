<?php

namespace App\Services\MessageService\Database\Factories;

use App\Services\MessageService\Models\StaticMessage;
use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticMessageFactory extends Factory
{
    protected $model = StaticMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group_id = StaticMessageGroup::query()->inRandomOrder()->first()?->id;

        if (! $group_id) {
            $group_id = StaticMessageGroup::factory()->create()->id;
        }

        return [
            'group_id'  => $group_id,
            'title'     => fake()->jobTitle,
            'message'   => fake()->text(50),
            'is_active' => 1
        ];
    }
}
