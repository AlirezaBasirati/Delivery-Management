<?php

namespace App\Services\AuthenticationService\Database\Factories;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id'     => 1,
            'role_id'       => Role::ADMIN->value,
            'username'      => fake()->userName() . rand(1, 9999999),
            'email'         => rand(1, 9999999) . fake()->unique()->safeEmail(),
            'first_name'    => fake()->firstName(),
            'last_name'     => fake()->lastName(),
            'national_code' => fake()->postcode(),
            'mobile'        => '09' . rand(100000000, 999999999),
            'password'      => 'password',
            'birth_date'    => now()->subYears(30)->format('Y-m-d'),
            'status'        => 1,
        ];
    }
}
