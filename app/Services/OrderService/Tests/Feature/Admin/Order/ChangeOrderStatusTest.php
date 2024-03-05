<?php

namespace App\Services\OrderService\Tests\Feature\Admin\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeOrderStatusTest extends TestCase
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
    public function test_success_change_order_status(): void
    {
        $order = Statics::createOrder(OrderStatus::ASSIGNED->value);

        $response = $this->actingAs($this->user)
            ->postJson("/api/admin/v1/orders/$order->id/change-status", [
                'status_id' => OrderStatus::START->value
            ]);

        $response->assertSuccessful();
    }

    /**
     * orders list
     *
     * @return void
     */
    public function test_error_change_order_status(): void
    {
        $order = Statics::createOrder(OrderStatus::PENDING->value, true);

        $response = $this->actingAs($this->user)
            ->postJson("/api/admin/v1/orders/$order->id/change-status", [
                'status_id' => OrderStatus::START->value
            ]);

        $response->assertUnprocessable();
    }
}
