<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NeedSupportTest extends TestCase
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
     * 1. store an order and assign to driver
     * 2. Request to store need support log
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_success_need_support_request(): void
    {
        Statics::setOrderForDriver($this->driver, OrderStatus::ASSIGNED->value);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/need-support');

        $response->assertSuccessful();
    }

    /**
     * steps:
     * Request to store need support log when driver has no active order
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_need_support_request_when_no_order(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/need-support');

        $response->assertNotFound();
    }
}
