<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersListTest extends TestCase
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
     * driver orders history
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_list_of_driver_orders(): void
    {
        $response = $this->actingAs($this->driver->user)
            ->get('/api/driver/v1/orders');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'code',
                        'last_state',
                        'cod_amount',
                        'pick_up',
                        'drop_off',
                        'created_at'
                    ]
                ]
            ]);
    }
}
