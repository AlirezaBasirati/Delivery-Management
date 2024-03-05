<?php

namespace App\Services\OrderService\Tests\Feature\Driver\BroadcastOrder;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnAssignOrdersCountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private mixed $token = null;
    private Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');

        $this->driver = Statics::selectDriver();
    }

    /**
     * steps:
     * 1. store an order near the driver's zone
     * 2. Request to accept the order by the driver
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_un_assign_orders_count(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/driver/v1/broadcast-orders/un-assigned-count');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'count'
                ]
            ]);
    }
}
