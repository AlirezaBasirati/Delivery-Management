<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\OrderItem;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReturnOrderTest extends TestCase
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
     * return order by driver possible when next status id done
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_return_order_by_driver(): void
    {
        $order = Statics::setOrderForDriver($this->driver, OrderStatus::ARRIVED);

        /** @var OrderItem $random_item */
        $random_item = $order->items()->inRandomOrder()->first();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/return', [
                'items' => [
                    [
                        'id'                => $random_item->id,
                        'returned_quantity' => floor(($random_item->quantity / 2) + 1)
                    ]
                ]
            ]);

        $response->assertSuccessful();
    }

    /**
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_validation_error_when_return_order_by_driver(): void
    {
        $order = Statics::setOrderForDriver($this->driver, OrderStatus::ASSIGNED);

        /** @var OrderItem $random_item */
        $random_item = $order->items()->inRandomOrder()->first();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/return', [
                'items' => [
                    [
                        'returned_quantity' => floor(($random_item->quantity / 2) + 1)
                    ]
                ]
            ]);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'data' => [
                    'items.0.id'
                ]
            ]);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/return', [
                'items' => [
                    [
                        'id' => $random_item->id
                    ]
                ]
            ]);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'data' => [
                    'items.0.returned_quantity'
                ]
            ]);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/return');

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'data' => [
                    'items'
                ]
            ]);
    }
}
