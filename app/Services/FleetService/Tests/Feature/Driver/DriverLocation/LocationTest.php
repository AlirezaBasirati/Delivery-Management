<?php

namespace App\Services\FleetService\Tests\Feature\Driver\DriverLocation;

use App\Services\FleetService\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        /** @var Driver $driver */
        $driver = Driver::query()
            ->inRandomOrder()
            ->first();

        $this->driver = $driver;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_location(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/driver-locations', [
                'latitude'  => fake()->latitude,
                'longitude' => fake()->longitude
            ]);

        $response->assertSuccessful();
    }

    /** @dataProvider invalidStoreLocationData */
    public function test_store_location_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->driver->user)
            ->post('/api/driver/v1/driver-locations', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidStoreLocationData(): array
    {
        $data = [
            'latitude'  => fake()->latitude(30, 40),
            'longitude' => fake()->longitude(50, 60),
        ];

        $latitude_required = $data;
        unset($latitude_required['latitude']);

        $latitude_invalid = $data;
        $latitude_invalid['latitude'] = fake()->latitude(90, 100);

        $longitude_required = $data;
        unset($longitude_required['longitude']);

        $longitude_invalid = $data;
        $longitude_invalid['longitude'] = fake()->longitude(180, 190);

        return [
            'latitude.required' => [$latitude_required, 'latitude'],
            'latitude.invalid'  => [$latitude_invalid, 'latitude'],

            'longitude.required' => [$longitude_required, 'longitude'],
            'longitude.invalid'  => [$longitude_invalid, 'longitude'],
        ];
    }

}
