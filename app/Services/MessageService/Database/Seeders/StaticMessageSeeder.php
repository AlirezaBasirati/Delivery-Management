<?php

namespace App\Services\MessageService\Database\Seeders;

use App\Services\MessageService\Models\StaticMessage;
use Illuminate\Database\Seeder;

class StaticMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $messages = [
            [
                'id'    => 1,
                'group_id' => 1,
                'title' => 'inability_to_complete_order',
                'message' => 'عدم امکان انجام سفر.'
            ],
            [
                'id'    => 2,
                'group_id' => 1,
                'title' => 'accident',
                'message' => 'تصادف کردم.'
            ],
            [
                'id'    => 3,
                'group_id' => 1,
                'title' => 'punctured',
                'message' => 'موتور من پنچر است.'
            ],
            [
                'id'    => 4,
                'group_id' => 2,
                'title' => 'can_not_find_the_address',
                'message' => 'نمیتوانم آدرس را پیدا کنم.'
            ],
            [
                'id'    => 5,
                'group_id' => 2,
                'title' => 'wrong_address',
                'message' => 'آدرس اشتباه است.'
            ],
            [
                'id'    => 6,
                'group_id' => 2,
                'title' => 'customer_is_not_present',
                'message' => 'مشتری در مقصد حضور ندارد.'
            ],
            [
                'id'    => 7,
                'group_id' => 6,
                'title' => 'رسید سفر',
                'message' => 'رسید سفرم را میخواهم'
            ],
            [
                'id'    => 8,
                'group_id' => 6,
                'title' => 'هزینه سفر',
                'message' => 'با محاسبه مجدد هزینه سفر مشکل دارم'
            ],
            [
                'id'    => 9,
                'group_id' => 6,
                'title' => 'هزینه پیک',
                'message' => 'مشکلی با هزینه پیک دارم'
            ],
            [
                'id'    => 10,
                'group_id' => 6,
                'title' => 'اعتبار',
                'message' => 'از اعتبار من هزینه بیشتری کسر شد'
            ],
            [
                'id'    => 11,
                'group_id' => 6,
                'title' => 'مشکل هزینه ی لغو سفر',
                'message' => 'مشکلی با هزینه لغو سفر دارم'
            ],
            [
                'id'    => 12,
                'group_id' => 6,
                'title' => 'پرداخت آنلاین',
                'message' => 'بعد از پرداخت آنلاین میزان اعتبار حساب من افزایش پیدا نکرد'
            ]
        ];

        StaticMessage::query()->truncate();

        foreach ($messages as $message) {
            StaticMessage::query()->create($message);
        }
    }
}
