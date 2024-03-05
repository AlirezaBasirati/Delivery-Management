<?php

namespace App\Services\MessageService\Database\Seeders;

use App\Services\MessageService\Models\StaticMessage;
use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StaticMessageGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $message_groups = [
            [
                'id'      => 1,
                'title'   => 'عدم امکان انجام سفر',
                'name'    => 'support',
                'reserve' => true
            ],
            [
                'id'      => 2,
                'title'   => 'نیاز به پشتیبانی برای تکمیل سفر',
                'name'    => 'support',
                'reserve' => true
            ],
            [
                'id'      => 3,
                'title'   => 'چه مشکلی پیش آمده است؟',
                'name'    => 'customer_ticket',
                'reserve' => true
            ],
            [
                'id'        => 4,
                'title'     => 'مشکلی با راننده داشتم',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ],
            [
                'id'        => 5,
                'title'     => 'مشکلی با هزینه پیک داشتم',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ],
            [
                'id'        => 6,
                'title'     => 'مشکلی با هزینه اپلیکیشن داشتم',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ],
            [
                'id'        => 7,
                'title'     => 'درخواست استرداد وجه',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ],
            [
                'id'        => 8,
                'title'     => 'گزارش سفیر خاطی و یا وقوع حادثه',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ],
            [
                'id'        => 9,
                'title'     => 'خطا در پرداخت هزینه های سفر',
                'name'      => 'customer_ticket_problem',
                'reserve'   => true,
                'parent_id' => 3
            ]
        ];
        Schema::disableForeignKeyConstraints();

        StaticMessageGroup::query()->truncate();

        Schema::enableForeignKeyConstraints();

        foreach ($message_groups as $message_group) {
            StaticMessageGroup::query()->create($message_group);
        }

    }
}
