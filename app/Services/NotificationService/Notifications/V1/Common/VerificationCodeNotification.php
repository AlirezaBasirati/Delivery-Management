<?php

namespace App\Services\NotificationService\Notifications\V1\Common;

use Kavenegar\LaravelNotification\KavenegarChannel;
use Illuminate\Notifications\Notification;

class VerificationCodeNotification extends Notification
{
    public function __construct(private readonly string $code)
    {
    }

    public function via($notifiable): array
    {
        return [KavenegarChannel::class];
    }

    public function toSMS($notifiable): string
    {
        return __('messages.verification_code', ['attribute' => $this->code]);
    }
}
