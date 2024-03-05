<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\MessageService\Enumerations\V1\StaticMessageGroup;
use App\Services\MessageService\Models\StaticMessage;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnAssignOrderTest extends TestCase
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
    public function test_un_assign_order_by_driver(): void
    {
        Statics::setOrderForDriver($this->driver, OrderStatus::ASSIGNED);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/un-assign', ['static_message_id' => $static_message->id]);

        $response->assertSuccessful();
    }
}
