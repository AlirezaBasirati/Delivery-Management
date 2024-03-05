<?php

namespace App\Services\MessageService\Database\Factories;

use App\Services\MessageService\Models\StaticMessage;
use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticMessageGroupFactory extends Factory
{
    protected $model = StaticMessageGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'    => fake()->jobTitle,
            'name'     => fake()->userName(),
            'reserve'  => 0
        ];
    }
}
