<?php

namespace App\Services\OrderService\Database\Factories;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\OrderStatusLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusLogFactory extends Factory
{
    protected $model = OrderStatusLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_status_id' => OrderStatus::DONE->value,
        ];
    }
}
