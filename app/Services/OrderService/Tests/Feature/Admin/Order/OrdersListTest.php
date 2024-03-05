<?php

namespace App\Services\OrderService\Tests\Feature\Admin\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersListTest extends TestCase
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
    public function test_list_of_orders(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/api/admin/v1/orders');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'pick_up',
                        'drop_off',
                        'driver',
                        'created_at',
                        'permissions' => [
                            'assign_driver',
                            'un_assign_driver'
                        ]
                    ]
                ]
            ]);
    }
}
