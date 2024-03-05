<?php

namespace App\Services\OrderService\Jobs\V1\Common;

use App\Services\AuthenticationService\Models\User;
use App\Services\NotificationService\Notifications\V1\Driver\OrdersCountNotification;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class BroadcastOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(BroadcastOrderInterface $broadcastOrderService): void
    {
        if (! config('order.send_with_broadcast')) {
            return;
        }

        $this->order->drivers()
            ->where('is_free', 1)
            ->where('status', 1)
            ->select('drivers.*')
            ->chunk(30, function ($drivers) use ($broadcastOrderService) {
                foreach ($drivers as $driver) {
                    $broadcastOrderService->sendPendingCount($driver);
                }
            });
    }
}
