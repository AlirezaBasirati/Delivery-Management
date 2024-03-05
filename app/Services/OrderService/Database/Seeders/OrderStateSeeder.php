<?php

namespace App\Services\OrderService\Database\Seeders;

use App\Services\OrderService\Models\OrderState;
use Illuminate\Database\Seeder;

class OrderStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $order_statuses = [
            [
                'id'    => 1,
                'title' => 'در انتظار یافتن راننده',
                'name'  => 'pending',
            ],
            [
                'id'    => 2,
                'title' => 'در مسیر',
                'name'  => 'processing',
            ],
            [
                'id'    => 3,
                'title' => 'حذف راننده',
                'name'  => 'unassigned',
            ],
            [
                'id'    => 4,
                'title' => 'تحویل شده',
                'name'  => 'done',
            ],
            [
                'id'    => 5,
                'title' => 'لغو شده',
                'name'  => 'canceled',
            ],
            [
                'id'    => 6,
                'title' => 'مرجوع شده',
                'name'  => 'returned',
            ],
            [
                'id'    => 7,
                'title' => 'عدم یافتن راننده',
                'name'  => 'no_driver_fount',
            ],
        ];

        OrderState::query()->truncate();

        foreach ($order_statuses as $order_status) {
            OrderState::query()->create($order_status);
        }
    }
}
