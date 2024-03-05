<?php

namespace App\Services\OrderService\Tests\Feature\Admin\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use App\Services\MessageService\Enumerations\V1\StaticMessageGroup;
use App\Services\MessageService\Models\StaticMessage;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignDriverFromOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $admin;
    private Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');

        $this->admin = Statics::selectAdminUser();
        $this->driver = Statics::selectDriver();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_success_assign(): void
    {
        $order = Statics::createOrder(OrderStatus::PENDING->value, true);

        $broadcast_order_service = $this->app->make(BroadcastOrderInterface::class);
        $broadcast_order_service->storeMany([
            [
                'order_id'   => $order->id,
                'driver_id'  => $this->driver->id,
                'vehicle_id' => $this->driver->currentVehicle->id
            ]
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id);

        $response->assertSuccessful();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_success_assign_before_pick_up(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::ASSIGNED->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, ['static_message_id' => $static_message->id]);

        $response->assertSuccessful();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_success_assign_after_pick_up_with_old_driver_location(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::PICKED_UP->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, [
                'static_message_id'      => $static_message->id,
                'is_old_driver_location' => 1
            ]);

        $response->assertSuccessful();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_error_assign_after_pick_up_with_old_driver_location(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::PICKED_UP->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, [
                'static_message_id' => $static_message->id
            ]);

        $response->assertUnprocessable();
    }


    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_success_assign_after_pick_up_without_old_driver_location(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::PICKED_UP->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, [
                'static_message_id'      => $static_message->id,
                'is_old_driver_location' => 1,
                'pick_up'                => [
                    'latitude'  => fake()->latitude(30, 40),
                    'longitude' => fake()->longitude(50, 60),
                    'name'      => 'name',
                    'address'   => 'address',
                    'phone'     => fake()->phoneNumber
                ]
            ]);

        $response->assertSuccessful();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_error_assign_after_pick_up_without_old_driver_location(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::PICKED_UP->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $data = [
            'static_message_id'      => $static_message->id,
            'is_old_driver_location' => 0,
            'pick_up'                => [
                'latitude'  => fake()->latitude(30, 40),
                'longitude' => fake()->longitude(50, 60),
                'name'      => 'name',
                'address'   => 'address',
                'phone'     => fake()->phoneNumber
            ]
        ];

        foreach ($data as $key => $value) {
            $temp_data = $data;
            unset($temp_data[$key]);

            $response = $this->actingAs($this->admin)
                ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, $temp_data);

            $response->assertUnprocessable();
        }
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_error_assign_when_order_is_in_cancel_status(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::CUSTOMER_CANCELED->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, [
                'static_message_id'      => $static_message->id,
                'is_old_driver_location' => 1
            ]);

        $response->assertUnprocessable();
    }

    /**
     * steps:
     * 1. store an order for a random free driver
     * 2. Request to un assign the driver from order
     *
     * @return void
     */
    public function test_error_assign_when_order_is_in_done_status(): void
    {
        $order = Statics::setOrderForDriver(null, OrderStatus::DONE->value);

        $static_message = StaticMessage::query()
            ->where('group_id', StaticMessageGroup::UN_ASSIGN_DRIVER->value)
            ->inRandomOrder()
            ->first();

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/v1/orders/$order->id/assign-driver/" . $this->driver->id, [
                'static_message_id'      => $static_message->id,
                'is_old_driver_location' => 1
            ]);

        $response->assertUnprocessable();
    }
}
