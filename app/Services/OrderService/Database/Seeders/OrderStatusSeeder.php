<?php

namespace App\Services\OrderService\Database\Seeders;

use App\Services\OrderService\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $order_states = [
            [
                'id'             => 1,
                'name'           => 'pending',
                'state_id'       => 1,
                'next_status_id' => null,
                'title'          => 'در انتظار یافتن راننده',
                'for_driver'     => 0,
                'sort'           => 0,
                'reserve'        => 1,
                'code'           => '101'
            ],
            [
                'id'             => 2,
                'name'           => 'assigned',
                'state_id'       => 2,
                'next_status_id' => 3,
                'title'          => 'اختصاص به راننده',
                'for_driver'     => 0,
                'sort'           => 1,
                'reserve'        => 1,
                'code'           => '201'
            ],
            [
                'id'             => 3,
                'name'           => 'start',
                'state_id'       => 2,
                'next_status_id' => 4,
                'title'          => 'شروع',
                'for_driver'     => 1,
                'sort'           => 2,
                'reserve'        => 0,
                'code'           => '202'
            ],
            [
                'id'             => 4,
                'name'           => 'picking_up',
                'state_id'       => 2,
                'next_status_id' => 5,
                'title'          => 'به مبدا رسیدم',
                'for_driver'     => 1,
                'sort'           => 3,
                'reserve'        => 0,
                'code'           => '203'
            ],
            [
                'id'             => 5,
                'name'           => 'picked_up',
                'state_id'       => 2,
                'next_status_id' => 6,
                'title'          => 'تحویل گرفتم',
                'for_driver'     => 1,
                'sort'           => 4,
                'reserve'        => 1,
                'code'           => '204'
            ],
            [
                'id'             => 6,
                'name'           => 'on_the_way',
                'state_id'       => 2,
                'next_status_id' => 8,
                'title'          => 'به سمت مقصد',
                'for_driver'     => 1,
                'sort'           => 4,
                'reserve'        => 1,
                'code'           => '205'
            ],
            [
                'id'             => 7,
                'name'           => 'on_the_next_way',
                'state_id'       => 2,
                'next_status_id' => 8,
                'title'          => 'به سمت مقصد بعدی',
                'for_driver'     => 1,
                'sort'           => 4,
                'reserve'        => 1,
                'code'           => '206'
            ],
            [
                'id'             => 8,
                'name'           => 'arrived',
                'state_id'       => 2,
                'next_status_id' => 9,
                'title'          => 'به مقصد رسیدم',
                'for_driver'     => 1,
                'sort'           => 5,
                'reserve'        => 0,
                'code'           => '207'
            ],
            [
                'id'             => 9,
                'name'           => 'done',
                'state_id'       => 4,
                'next_status_id' => null,
                'title'          => 'تحویل شد',
                'for_driver'     => 1,
                'sort'           => 6,
                'reserve'        => 1,
                'code'           => '401'
            ],
            [
                'id'             => 10,
                'name'           => 'need_support',
                'state_id'       => 2,
                'next_status_id' => null,
                'title'          => 'نیاز به پشتیبانی',
                'for_driver'     => 0,
                'sort'           => 7,
                'reserve'        => 1,
                'code'           => '208'
            ],
            [
                'id'             => 11,
                'name'           => 'unassigned_before_picked_up',
                'state_id'       => 3,
                'next_status_id' => null,
                'title'          => 'حذف راننده قبل از دریافت سفارش',
                'for_driver'     => 0,
                'sort'           => 8,
                'reserve'        => 1,
                'code'           => '301'
            ],
            [
                'id'             => 12,
                'name'           => 'unassigned_after_picked_up',
                'state_id'       => 3,
                'next_status_id' => null,
                'title'          => 'حذف راننده بعد از دریافت سفارش',
                'for_driver'     => 0,
                'sort'           => 9,
                'reserve'        => 1,
                'code'           => '302'
            ],
            [
                'id'             => 13,
                'name'           => 'customer_canceled',
                'state_id'       => 5,
                'next_status_id' => null,
                'title'          => 'لغو سفارش از سمت مشتری',
                'for_driver'     => 0,
                'sort'           => 10,
                'reserve'        => 1,
                'code'           => '501'
            ],
            [
                'id'             => 14,
                'name'           => 'support_canceled',
                'state_id'       => 5,
                'next_status_id' => null,
                'title'          => 'لغو سفارش از سمت ساپورت',
                'for_driver'     => 0,
                'sort'           => 11,
                'reserve'        => 1,
                'code'           => '502'
            ],
            [
                'id'             => 15,
                'name'           => 'partial_return',
                'state_id'       => 6,
                'next_status_id' => 5,
                'title'          => 'برگشت قسمتی از سفارش',
                'for_driver'     => 0,
                'sort'           => 12,
                'reserve'        => 1,
                'code'           => '601'
            ],
            [
                'id'             => 16,
                'name'           => 'full_return',
                'state_id'       => 6,
                'next_status_id' => 5,
                'title'          => 'برگشت سفارش به صورت کامل',
                'for_driver'     => 0,
                'sort'           => 13,
                'reserve'        => 1,
                'code'           => '602'
            ],
            [
                'id'             => 17,
                'name'           => 'absence_of_receiver',
                'state_id'       => 6,
                'next_status_id' => 5,
                'title'          => 'برگشت سفارش به دلیل عدم حضور مشتری',
                'for_driver'     => 0,
                'sort'           => 14,
                'reserve'        => 1,
                'code'           => '603'
            ],
            [
                'id'             => 18,
                'name'           => 'no_driver_fount',
                'state_id'       => 7,
                'next_status_id' => null,
                'title'          => 'راننده ای یافت نشد',
                'for_driver'     => 0,
                'sort'           => 15,
                'reserve'        => 1,
                'code'           => '701'
            ],
        ];

        OrderStatus::query()->truncate();

        foreach ($order_states as $order_state) {
            OrderStatus::query()->create($order_state);
        }
    }
}
