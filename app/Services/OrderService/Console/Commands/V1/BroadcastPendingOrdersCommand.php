<?php

namespace App\Services\OrderService\Console\Commands\V1;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Enumerations\V1\OrderType;
use App\Services\OrderService\Jobs\V1\Common\FindDriversJob;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatusLog\OrderStatusLogInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BroadcastPendingOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:pending_orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param BroadcastOrderInterface $broadcastOrder
     * @param OrderStatusLogInterface $orderStatusLog
     * @return void
     */
    public function handle(BroadcastOrderInterface $broadcastOrder, OrderStatusLogInterface $orderStatusLog): void
    {
        $orders = Order::query()
            ->where('type', OrderType::ON_DEMAND->value)
            ->where('last_status_id', OrderStatus::PENDING->value);

        (clone $orders)->where('broadcast_count', '<', config('order.broadcast.count'))
            ->chunk(50, function ($orders) {
                foreach ($orders as $order) {
                    dispatch_sync(new FindDriversJob($order, false));
                }
            });

        Driver::query()
            ->where('is_free', 1)
            ->where('status', 1)
            ->chunk(30, function ($drivers) use ($broadcastOrder) {
                foreach ($drivers as $driver) {
                    $broadcastOrder->sendPendingCount($driver);
                    $broadcastOrder->sendPendingList($driver);
                }
            });

        (clone $orders)->where('broadcast_count', '>=', config('order.broadcast.count'))
            ->where('last_broadcast_at', '<', Carbon::now()->subMinutes(config('order.life_time'))->format('Y-m-d H:i:s'))
            ->chunk(50, function ($orders) use ($orderStatusLog) {
                foreach ($orders as $order) {
                    $orderStatusLog->store([
                        'order_id'        => $order->id,
                        'order_status_id' => OrderStatus::NO_DRIVER_FOUND->value
                    ]);
                }
            });
    }
}
