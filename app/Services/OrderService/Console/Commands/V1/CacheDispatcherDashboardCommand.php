<?php

namespace App\Services\OrderService\Console\Commands\V1;

use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface;
use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\Order\OrderInterface;
use App\Services\OrderService\Repository\V1\Common\OrderStatus\OrderStatusInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class CacheDispatcherDashboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:dispatcher_dashboard';

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
    public function __construct(
        private readonly OrderInterface $order_service,
        private readonly DriverInterface      $driver_service
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param OrderStatusInterface $order_status_service
     * @return void
     * @throws InvalidArgumentException
     */
    public function handle(OrderStatusInterface $order_status_service): void
    {
        $dispatcher_dashboard = (array)Cache::driver(env('DASHBOARD_CACHE_DRIVER') ?? 'database')->get('dispatcher_dashboard') ?? [];

        $need_cache_order = Order::query()->where('updated_at', '>', Carbon::now()->subSeconds(20))->exists();

        if ($need_cache_order) {
            $order_statuses = $order_status_service->ordersCount();

            $dispatcher_dashboard['orders_count'] = $order_statuses->map(function ($orderStatus) {
                return [
                    'id'           => $orderStatus->id,
                    'title'        => $orderStatus->title,
                    'name'         => $orderStatus->name,
                    'orders_count' => $orderStatus->orders()
                        ->where('created_at', '>', Carbon::today('Asia/Tehran'))
                        ->count()
                ];
            })->toArray();

            $orders = [];

            foreach ($order_statuses as $order_status) {
                $orders[$order_status->name] = $this->orders(['status_ids' => [$order_status->id]]);
            }

            // un assigned
            $orders['un_assigned'] = $this->orders([
                'status_ids' => [
                    OrderStatus::UNASSIGNED_BEFORE_PICKED_UP->value,
                    OrderStatus::UNASSIGNED_AFTER_PICKED_UP->value,
                ]
            ]);

            // canceled
            $orders['canceled'] = $this->orders([
                'status_ids' => [
                    OrderStatus::CUSTOMER_CANCELED->value,
                    OrderStatus::SUPPORT_CANCELED->value,
                ]
            ]);

            // returned
            $orders['returned'] = $this->orders(['status_ids' => [
                OrderStatus::PARTIAL_RETURN->value,
                OrderStatus::COMPLETE_RETURN->value,
                OrderStatus::ABSENCE_OF_RECEIVER->value,
            ]]);

            $dispatcher_dashboard['orders'] = $orders;
        }


        $need_cache_driver = Driver::query()->where('updated_at', '>', Carbon::now()->subSeconds(20))->exists();

        if ($need_cache_driver) {
            $dispatcher_dashboard['drivers']['online'] = $this->drivers(['status' => 1]);
            $dispatcher_dashboard['drivers']['offline'] = $this->drivers(['status' => 0]);
        }

        Cache::forget('dispatcher_dashboard');

        Cache::driver(env('DASHBOARD_CACHE_DRIVER') ?? 'database')
            ->put('dispatcher_dashboard', $dispatcher_dashboard, Carbon::today()->addDay());
    }

    private function orders(array $filters = [])
    {
        return $this->order_service->index($filters)->map(function ($order) {
            $last_state = $order->lastStatus->state_id;
            $assign_permission = !in_array($last_state, [OrderState::DONE->value, OrderState::CANCELED->value]);

            $driver = $order->driver;

            $pick_up = $order->current_pick_up ?? $order->last_pick_up;
            $drop_off = $order->current_drop_off ?? $order->drop_offs->first();

            return [
                'id'          => $order->id,
                'code'        => $order->code,
                'pick_up'     => $pick_up->only('id', 'address', 'latitude', 'longitude'),
                'drop_off'    => $drop_off->only('id', 'address', 'latitude', 'longitude'),
                'driver'      => $order->is_processing && $driver ? [
                    'id'        => $driver->id,
                    'user'      => $driver->user->only('id', 'first_name', 'last_name'),
                    'latitude'  => $driver->latitude,
                    'longitude' => $driver->longitude,
                ] : null,
                'created_at'  => $order->created_at->format('Y-m-d H:i:s'),
                'picked_up'   => is_null($order->current_pick_up),
                'permissions' => [
                    'assign_driver'    => $assign_permission,
                    'un_assign_driver' => isset($order->driver_id) && $assign_permission,
                    'broadcast'        => $last_state == OrderState::UNASSIGNED->value
                ]
            ];
        })->toArray();
    }

    private function drivers(array $filters = []) {
        return $this->driver_service->index($filters)->map(function ($driver) {
            $order_status = $driver->currentOrder?->lastStatus;

            return [
                'id'           => $driver->id,
                'user'         => $driver->user->only('id', 'first_name', 'last_name'),
                'order_status' => $order_status?->only('id', 'name', 'title')
            ];
        })->toArray();
    }
}
