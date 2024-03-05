<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\OrderService\Models\OrderState;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStateFactory extends Factory
{
    protected $model = OrderState::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'name'  => fake()->title,
        ];
    }
}
