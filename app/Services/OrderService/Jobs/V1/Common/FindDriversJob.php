<?php

namespace App\Services\OrderService\Jobs\V1\Common;

use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class FindDriversJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Order $order, private readonly bool $with_broadcast = true)
    {
        //
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(DriverInterface $driver, BroadcastOrderInterface $broadcast_order): void
    {
        $pick_up = $this->order->current_pick_up;

        $driversQuery = $driver->nearestQuery([
            'location' => [
                'latitude'  => $pick_up->latitude,
                'longitude' => $pick_up->longitude
            ],
            'distance' => env('MAP_RADIUS')
        ], [
            'status'    => true,
            'is_free'   => true,
            'tenant_id' => $this->order->tenant_id
        ]);

        $broadcast_order->fillAssignedAt($this->order, $driversQuery->pluck('id')->toArray());

        if (!(clone $driversQuery)->count()) {
            return;
        }

        DB::beginTransaction();

        $this->order->broadcast_count += 1;
        $this->order->last_broadcast_at = Carbon::now();
        $this->order->save();

        (clone $driversQuery)->chunk(30, function ($drivers) use ($broadcast_order) {
            foreach ($drivers as $driver) {
                dispatch(new AssignNewOrderToDriverJob($this->order, $driver, $this->with_broadcast));
            }
        });

        DB::commit();

//        (clone $driversQuery)->chunk(30, function ($drivers) use ($pick_up, $drop_off, $broadcast_order) {
//            try {
//                $promises = [];
//
//                foreach ($drivers as $driver) {
//                    $promises[] = Http::async()
//                        ->withHeaders(['x-api-key' => env('MAP_KEY')])
//                        ->get(env('MAP_URL') . "eta/driving/$driver->longitude,$driver->latitude;$pick_up->longitude,$pick_up->latitude;$drop_off->longitude,$drop_off->latitude")
//                        ->then(function ($response) use ($driver) {
//                            // The map service may not respond or receive an error. In this case, we send an order to all drivers whose distance is less than the specified radius
//                            if (
//                                $response instanceof ConnectException ||
//                                (isset($response['routes']) && $response['routes']['duration'] < config('order.delivery_time')) ||
//                                !$response->successful()
//                            ) {
//                                dispatch(new AssignNewOrderToDriverJob($this->order, $driver, $this->with_broadcast));
//                            }
//                        });
//                }
//
//                // A driver may have accepted the order while we were looking for a driver
//                if ($this->order->broadcast_count > 1 && $this->order->refresh()->last_status_id != OrderStatus::PENDING->value) {
//                    $broadcast_order->fillAssignedAt($this->order);
//                    return;
//                }
//
//                $responses = Utils::unwrap($promises);
//            }
//            catch (\Exception $exception) {
//                // Sometimes the map does not respond
//                return;
//            }
//        });
    }
}
