<?php

namespace App\Services\OrderService\Tests\Feature\Driver\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcceptOrderTest extends TestCase
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
    public function test_success_accept_order_by_driver(): void
    {
        $this->storeOrder();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/accept');

        $response->assertSuccessful();
    }

    /**
     *
     * steps:
     * 1. store an order near the driver's zone
     * 2. Request to accept the order by the driver with sending the order id
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_success_accept_specific_order_by_driver(): void
    {
        $order = $this->storeOrder();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/accept', ['order_id' => $order->id]);

        $response->assertSuccessful();
    }

    /**
     *  steps:
     *  1. store an order out of the driver's area
     *  2. Request to accept the order by the driver with sending order id
     *     Accepting for that order by the driver should return 422 because the order is out of zone
     *
     *  notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_wrong_accept_specific_order_by_driver(): void
    {
        $order = $this->storeOrder([
            "locations" => [
                [
                    "latitude"    => 35.748554,
                    "longitude"   => 51.233523,
                    "name"        => "فروشگاه چیتگر",
                    "address"     => "تهران - چیتگر - میدان دریاچه - خیابان جوزانی - پلاک 420",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "pick_up"
                ],
                [
                    "latitude"    => 35.808269,
                    "longitude"   => 51.408377,
                    "name"        => "ریحانه حسینی",
                    "address"     => "تهران - ولنجک - خیابان ولنجک - کوچه ی 17 - پلاک 30",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "drop_off"
                ]
            ]
        ]);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/accept', ['order_id' => $order->id]);

        $response->assertUnprocessable()
            ->assertJson([
                'data' => [
                    'order_id' => [
                        __('messages.order_is_not_for_driver')
                    ]
                ]
            ]);
    }

    /**
     * steps:
     * 1. store an order out of the driver's area
     * 2. Request to accept one order by the driver without sending order id
     *    Accepting for that order by the driver should return 422 because the order is out of zone
     *
     * notice: a driver with active status created in setup
     *
     * @return void
     */
    public function test_no_order_when_accept_order_by_driver(): void
    {
        $this->storeOrder([
            "locations" => [
                [
                    "latitude"    => 35.748554,
                    "longitude"   => 51.233523,
                    "name"        => "فروشگاه چیتگر",
                    "address"     => "تهران - چیتگر - میدان دریاچه - خیابان جوزانی - پلاک 420",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "pick_up"
                ],
                [
                    "latitude"    => 35.808269,
                    "longitude"   => 51.408377,
                    "name"        => "ریحانه حسینی",
                    "address"     => "تهران - ولنجک - خیابان ولنجک - کوچه ی 17 - پلاک 30",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "drop_off"
                ]
            ]
        ]);

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/driver/v1/orders/accept');

        $response->assertUnprocessable()
            ->assertJson([
                'data' => [
                    'driver' => [
                        __('messages.no_order_for_driver')
                    ]
                ]
            ]);
    }

    private function storeOrder(array $parameters = []): Model
    {
        $data = [
            "code"             => "123456",
            "customer_id"      => 1,
            "parcel_value"     => 20000000,
            "price"            => 150000,
            "type"             => "on_demand",
            "cod_amount"       => 100000000,
            "package_quantity" => 2,
            "items"            => [
                [
                    "material_code" => "654321",
                    "name"          => "پنیر لبنه 400 گرمی",
                    "quantity"      => 2,
                    "size"          => "10,20,30",
                    "weight"        => 20
                ]
            ],
            "locations"        => [
                [
                    "latitude"    => 35.721221,
                    "longitude"   => 51.37104,
                    "name"        => "فروشگاه اپادانا",
                    "address"     => "تهران - خیابان خرمشهر - نرسیده به دشتک - پلاک 52 - طبقه 2",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "pick_up"
                ],
                [
                    "latitude"    => 35.73122,
                    "longitude"   => 51.38104,
                    "name"        => "ریحانه حسینی",
                    "address"     => "تهران - سعادت اباد - بالاتر از میدان کاج - کوچه ی 7",
                    "phone"       => "09123654789",
                    "postal_code" => "1234568790",
                    "type"        => "drop_off"
                ]
            ]
        ];

        $data = array_merge($data, $parameters);

        /** @var OrderInterface $order_service */
        $order_service = $this->app->make(OrderInterface::class);

        return $order_service->store($data);
    }
}
