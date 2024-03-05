<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeOrderStatusTest extends TestCase
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
    public function test_change_order_status_by_driver_when_does_not_have_any_order(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/change-status');

        $response->assertNotFound();
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
    public function test_change_order_status_by_driver(): void
    {
        Statics::setOrderForDriver($this->driver, OrderStatus::ASSIGNED->value);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/change-status');

        $response->assertSuccessful();
    }
}
