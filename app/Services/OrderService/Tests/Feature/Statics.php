<?php

namespace App\Services\OrderService\Tests\Feature;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderItem;
use App\Services\OrderService\Models\OrderLocation;
use App\Services\OrderService\Models\OrderStatusLog;
use App\Services\TenantService\Models\Tenant;

class Statics
{
    public static function orderResourceStructure(): array
    {
        return [
            'data' => [
                'id',
                'code',
                'last_status' => [
                    'title',
                    'name'
                ],
                'next_status' => [
                    'title',
                    'name'
                ],
                'cod_amount',
                'package_quantity',
                'duration_to_next_location',
                'distance_from_next_location',
                'picked_up',
                'returned',
                'pick_up'     => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'latitude',
                    'longitude',
                    'delivered_at'
                ],
                'drop_off'    => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'latitude',
                    'longitude',
                    'delivered_at'
                ],
                'created_at'
            ]
        ];
    }

    public static function selectDriver(): Driver|null
    {
        /** @var Driver $driver */
        $driver = Driver::query()
            ->where('status', true)
            ->where('is_free', true)
            ->inRandomOrder()
            ->first();

        return $driver;
    }

    public static function selectAdminUser(): User|null
    {
        /** @var User $user */
        $user = User::query()
            ->where('role_id', Role::ADMIN->value)
            ->distinct()
            ->inRandomOrder()
            ->first();

        return $user;
    }

    public static function selectCustomerUser(): User|null
    {
        /** @var User $user */
        $user = User::query()
            ->where('role_id', Role::CUSTOMER->value)
            ->distinct()
            ->inRandomOrder()
            ->first();

        return $user;
    }

    public static function setOrderForDriver($driver, $status_id): Order
    {
        if (!$driver) {
            $driver = self::selectDriver();
        }

        $dispatcher = Order::getEventDispatcher();
        Order::unsetEventDispatcher();

        $order = Order::factory()
            ->state(function () use ($driver, $status_id) {
                return [
                    'last_status_id' => $status_id,
                    'driver_id'      => $driver->id,
                    'vehicle_id'     => $driver->currentVehicle->id,
                    'is_processing'  => true
                ];
            })
            ->has(OrderItem::factory()->count(3), 'items')
            ->has(
                OrderLocation::factory()->count(1)
                    ->state(function () use ($status_id) {
                        return [
                            'delivered_at' => $status_id < OrderStatus::PICKED_UP->value ? null : now()
                        ];
                    }),
                'locations'
            )
            ->has(
                OrderLocation::factory()
                    ->count(1)
                    ->state(function () {
                        return [
                            'type'         => OrderLocationType::DROP_OFF->value,
                            'latitude'     => '35.73122',
                            'longitude'    => '51.381040',
                            'delivered_at' => null
                        ];
                    }),
                'locations'
            )
            ->has(
                OrderStatusLog::factory()
                    ->count(1)
                    ->state(function () use ($status_id) {
                        return [
                            'order_status_id' => $status_id
                        ];
                    }),
                'statusLogs'
            )
            ->create();


        Order::setEventDispatcher($dispatcher);

        $driver->is_free = false;
        $driver->save();

        /** @var Order $order */
        return $order;
    }

    public static function createOrder($status_id = null, $new = false): Order
    {
        $dispatcher = Order::getEventDispatcher();
        Order::unsetEventDispatcher();

        $status_id = $status_id ?? OrderStatus::PENDING->value;

        $data = [
            'last_status_id' => $status_id,
            'is_processing'  => true
        ];

        if ($new) {
            $data['driver_id'] = null;
            $data['vehicle_id'] = null;
            $data['is_processing'] = false;
        }

        $order = Order::factory()
            ->state(function () use ($data) {
                return $data;
            })
            ->has(OrderItem::factory()->count(3), 'items')
            ->has(
                OrderLocation::factory()->count(1)
                    ->state(function () {
                        return [
                            'delivered_at' => null
                        ];
                    }),
                'locations'
            )
            ->has(
                OrderLocation::factory()
                    ->count(1)
                    ->state(function () {
                        return [
                            'type'         => OrderLocationType::DROP_OFF->value,
                            'latitude'     => '35.73122',
                            'longitude'    => '51.381040',
                            'delivered_at' => null
                        ];
                    }),
                'locations'
            )
            ->has(
                OrderStatusLog::factory()
                    ->count(1)
                    ->state(function () use ($status_id) {
                        return [
                            'order_status_id' => $status_id
                        ];
                    }),
                'statusLogs'
            )
            ->create();


        Order::setEventDispatcher($dispatcher);

        /** @var Order $order */
        return $order;
    }

    public static function orderData(): array
    {
        $order = Order::factory()->make()->toArray();
        unset($order['last_status_id'], $order['is_processing'], $order['driver_id'], $order['vehicle_id']);

        $order['locations'][] = OrderLocation::factory()
            ->state(function () {
                return [
                    'delivered_at' => null,
                ];
            })
            ->make()
            ->toArray();

        $order['locations'][] = OrderLocation::factory()
            ->state(function () {
                return [
                    'delivered_at' => null,
                    'type'         => OrderLocationType::DROP_OFF->value,
                ];
            })
            ->make()
            ->toArray();

        $order['items'] = OrderItem::factory()->count(3)->make()->toArray();

        $order['tenant_id'] = Tenant::query()->inRandomOrder()->first()->id;
        $order['customer'] = User::query()
            ->where('role_id', Role::CUSTOMER->value)
            ->inRandomOrder()
            ->first()
            ->only('first_name', 'last_name', 'mobile');

        return $order;
    }
}
