<?php

namespace App\Services\NotificationService\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PusheAndroidChannel
{

    public function send($notifiable, Notification $notification): void
    {

        $data = $notification->toPushe($notifiable);

        $this->sendPushNotificationByPushe($data);

    }

    public function sendPushNotificationByPushe(array $data): void
    {
        $data_to_pushe = [
            "app_ids"      => [env('PUSHE_APP_ID')],
            "data"         => [
                "title"   => "سفارش جدید",
                "content" => sprintf("شما %s  سفارش جدید دارید.", $data['orders_count'])
            ],
            "filters"      => [
                "phone_number" => [$data['phone_number']],
            ],
            'time_to_live' => env('PUSHE_TIME_TO_LIVE')
        ];

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withToken(env('PUSHE_TOKEN'), 'TOKEN')
                ->timeout(30)
                ->post(env('PUSHE_ANDROID_URL'), $data_to_pushe);

            if ($response->status() == 201) {
                Log::log([
                    'driver_phone_number' => $data['phone_number'],
                    'store_name'          => $data['store_name']
                ], 'debug', (array)'PUSH_NOTIFICATION_SENT_TO_THE_DRIVER_SUCCESSFULLY');
            } else {
                Log::log([
                    'driver_phone_number' => $data['phone_number'],
                    'store_name'          => $data['store_name']
                ], 'debug', (array)'PUSH_NOTIFICATION_FAILED');
            }

        } catch (\Exception $exception) {
            Log::log(
                ['exception' => $exception->getMessage()],
                'debug', (array)'SEND_TO_PUSHE_EXCEPTION'
            );
        }


    }
}
