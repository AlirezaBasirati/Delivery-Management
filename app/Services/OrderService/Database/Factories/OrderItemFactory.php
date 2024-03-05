<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\OrderService\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material_code' => (string) rand(10000000, 99999999),
            'name'          => fake()->name(),
            'quantity'      => rand(1, 10),
        ];
    }
}
