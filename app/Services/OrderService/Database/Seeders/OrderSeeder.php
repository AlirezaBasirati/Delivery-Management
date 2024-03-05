<?php

namespace App\Services\OrderService\Database\Seeders;

use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderItem;
use App\Services\OrderService\Models\OrderLocation;
use App\Services\OrderService\Models\OrderStatusLog;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $dispatcher = Order::getEventDispatcher();
        Order::unsetEventDispatcher();

        Order::factory()
            ->count(10)
            ->has(OrderItem::factory()->count(3), 'items')
            ->has(OrderLocation::factory()->count(1), 'locations')
            ->has(
                OrderLocation::factory()
                ->count(1)
                ->state(function () {
                    return [
                        'type' => OrderLocationType::DROP_OFF->value,
                        'latitude' => '35.73122',
                        'longitude' => '51.381040'
                    ];
                 }),
                'locations'
            )
            ->has(OrderStatusLog::factory()->count(1), 'statusLogs')
            ->create();

        Order::setEventDispatcher($dispatcher);
    }
}
