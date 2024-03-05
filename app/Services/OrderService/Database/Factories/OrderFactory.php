<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var Driver $driver */
        $driver = Driver::query()->inRandomOrder()->first();

        return [
            'code'             => (string)rand(100000, 99999999),
            'customer_id'      => 1,
            'tenant_id'        => 1,
            'parcel_value'     => rand(100000, 999999999),
            'price'            => rand(100000, 999999999),
            'type'             => OrderType::ON_DEMAND->value,
            'cod_amount'       => rand(100000, 999999999),
            'package_quantity' => rand(1, 10),
            'driver_id'        => $driver->id,
            'is_processing'    => false,
            'last_status_id'   => OrderStatus::DONE->value,
            'vehicle_id'       => optional($driver->current_vehicle)->id
        ];
    }
}
