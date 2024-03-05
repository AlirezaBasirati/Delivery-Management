<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\OrderStatus as OrderStatusModel;
use App\Services\OrderService\Models\OrderStatusLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusFactory extends Factory
{
    protected $model = OrderStatusModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var OrderStatusModel $next_status */
        $next_status = OrderStatusModel::query()->find(OrderStatus::START->value + 1);

        return [
            'name'           => fake()->title,
            'state_id'       => OrderState::PROCESSING->value,
            'next_status_id' => OrderStatus::START->value + 1,
            'title'          => fake()->title,
            'for_driver'     => 1,
            'sort'           => $next_status->sort,
            'reserve'        => 0,
            'code'           => '150'
        ];
    }
}
