<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Models\OrderLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLocationFactory extends Factory
{
    protected $model = OrderLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'latitude'     => '35.721221',
            'longitude'    => '51.371040',
            'name'         => fake()->name(),
            'address'      => fake()->address(),
            'phone'        => fake()->phoneNumber(),
            'postal_code'  => fake()->postcode(),
            'type'         => OrderLocationType::PICK_UP->value,
            'sort'         => 1,
            'delivered_at' => now()
        ];
    }
}
