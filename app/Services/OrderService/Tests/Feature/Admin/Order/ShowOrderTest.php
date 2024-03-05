<?php

namespace App\Services\OrderService\Tests\Feature\Admin\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowOrderTest extends TestCase
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
     * orders list
     *
     * @return void
     */
    public function test_show_order(): void
    {
        $order = Statics::createOrder();

        $response = $this->actingAs($this->user)
            ->getJson('/api/admin/v1/orders/' . $order->id);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'code',
                    'customer_id',
                    'last_status',
                    'type',
                    'cod_amount',
                    'package_quantity',
                    'driver',
                    'vehicle',
                    'picked_up',
                    'items',
                    'pick_ups',
                    'drop_offs',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
