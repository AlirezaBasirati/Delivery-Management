<?php

namespace App\Services\OrderService\Tests\Feature\Admin\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowOrderOnMapTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');

        $this->user = Statics::selectAdminUser();
    }

    /**
     * show the order that has driver on the map
     *
     * @return void
     */
    public function test_show_order_that_has_driver_on_map(): void
    {
        $order = Statics::createOrder();

        $response = $this->actingAs($this->user)
            ->getJson("/api/admin/v1/orders/$order->id/map");

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'pick_up' => [
                        'id',
                        'latitude',
                        'longitude'
                    ],
                    'drop_off' => [
                        'id',
                        'latitude',
                        'longitude'
                    ],
                    'driver'
                ]
            ]);
    }

    /**
     * Show the order that does not have a driver on the map
     *
     * @return void
     */
    public function test_show_order_that_does_not_have_driver_on_map(): void
    {
        $order = Statics::createOrder(OrderStatus::PENDING->value, true);

        $response = $this->actingAs($this->user)
            ->getJson("/api/admin/v1/orders/$order->id/map");

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'pick_up' => [
                        'id',
                        'latitude',
                        'longitude'
                    ],
                    'drop_off' => [
                        'id',
                        'latitude',
                        'longitude'
                    ],
                    'driver'
                ]
            ]);
    }
}
