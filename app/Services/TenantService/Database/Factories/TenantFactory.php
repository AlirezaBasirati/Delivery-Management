<?php

namespace App\Services\TenantService\Database\Factories;

use App\Services\TenantService\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        return [
            'key'         => $this->faker->word(),
            'name'        => $this->faker->name(),
            'phone'       => $this->faker->phoneNumber(),
            'webhook_url' => $this->faker->url(),
        ];
    }
}
