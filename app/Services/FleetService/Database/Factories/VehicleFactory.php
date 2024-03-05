<?php

namespace App\Services\FleetService\Database\Factories;

use App\Services\FleetService\Models\Vehicle;
use App\Services\FleetService\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'                 => fake()->name(),
            'description'           => fake()->realText(100),
            'icon'                  => null,
            'type_id'               => VehicleType::query()->inRandomOrder()->first()->id,
            'tenant_id'             => 1,
            'plate_number'          => rand(100000, 9999999),
            'chassis_number'        => rand(100000, 9999999),
            'construction_year'     => rand(1380, 1400),
            'insurance_expire_date' => (new \Carbon\Carbon)->addWeeks(50),
            'status'                => 1,
        ];
    }
}
