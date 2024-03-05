<?php

namespace App\Services\FleetService\Database\Factories;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'tenant_id' => 1,
            'emergency_mobile' => fake()->phoneNumber(),
            'license_number' => '1234567890',
            'latitude' => '35.719897',
            'longitude' => '51.339884',
            'status' => 1,
            'is_free' => true
        ];
    }
}
