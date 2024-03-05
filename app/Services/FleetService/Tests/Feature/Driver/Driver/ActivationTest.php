<?php

namespace App\Services\FleetService\Tests\Feature\Driver\Driver;

use App\Services\FleetService\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        /** @var Driver $driver */
        $driver = Driver::query()
            ->where('is_free', true)
            ->inRandomOrder()
            ->first();

        $this->driver = $driver;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_activation(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/drivers/activation', [
                'status' => true
            ]);

        $response->assertSuccessful();
    }

    /** @dataProvider invalidActivationData */
    public function test_activation_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->driver->user)
            ->post('/api/driver/v1/drivers/activation', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidActivationData(): array
    {
        return [
            'status.required' => [[], 'status'],
            'status.boolean'  => [['status' => fake()->text], 'status'],
        ];
    }

}
