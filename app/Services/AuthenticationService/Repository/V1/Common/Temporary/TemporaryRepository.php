<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\Temporary;

use App\Services\AuthenticationService\Models\Temporary;
use App\Services\NotificationService\Notifications\V1\Common\VerificationCodeNotification;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class TemporaryRepository extends BaseRepository implements TemporaryRepositoryInterface
{
    public function __construct(protected Temporary $temporary)
    {
        parent::__construct($this->temporary);
    }

    public function sendOTP(string $column, string $username): bool
    {
        /** @var Temporary $temporary */
        $temporary = $this->findByColumn($column, $username);

        if ($temporary) {
            if (now()->lte($temporary->send_at->addSeconds(env('VERIFICATION_CODE_TRY_TIME_LIMIT')))) {
                $temporary->increment('retries');
                throw new TooManyRequestsHttpException();
            }

            if (now()->gt($temporary->send_at->addSeconds(env('VERIFICATION_CODE_LIFETIME')))) {
                $temporary->code = '9876';//rand(1000, 9999);
            }
        }
        else {
            $temporary = new $this->temporary();
            $temporary->code = '9876';//rand(1000, 9999);
            $temporary->$column = $username;
        }

        $temporary->send_at = now();
        $temporary->retries++;
        $temporary->save();

        if ($column == 'mobile') {
//            Notification::route('sms', $username)->notify(new VerificationCodeNotification($temporary->code));
        }

        return true;
    }

    public function findByColumn(string $column, string $username): ?Temporary
    {
        /** @var Temporary $temporary */
        $temporary = $this->temporary->query()->where($column, $username)->first();
        return $temporary;
    }

    /**
     * @param string $column
     * @param string $username
     * @param string $code
     * @return void
     * @throws ValidationException
     */
    public function check(string $column, string $username, string $code): void
    {
        $temporary = Temporary::query()
            ->where($column, $username)
            ->firstOrFail();

        if ($temporary && $temporary->code != $code) {
            throw ValidationException::withMessages(['code' => __('messages.invalid_code')]);
        }

        $temporary->delete();
    }
}
