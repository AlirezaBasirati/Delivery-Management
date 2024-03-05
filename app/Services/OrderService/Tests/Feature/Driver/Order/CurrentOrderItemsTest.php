<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrentOrderItemsTest extends TestCase
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
     * Request to get current driver order items when driver has no active order
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_not_found_current_order_when_test_order_items(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/driver/v1/orders/current/items');

        $response->assertNotFound();
    }

    /**
     * steps:
     * 1. store an order and assign to driver
     * 2. Request to get current driver order
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_success_current_order_items(): void
    {
        Statics::setOrderForDriver($this->driver, OrderStatus::ASSIGNED->value);

        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/driver/v1/orders/current/items');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'material_code',
                        'name',
                        'quantity'
                    ]
                ]
            ]);
    }
}
