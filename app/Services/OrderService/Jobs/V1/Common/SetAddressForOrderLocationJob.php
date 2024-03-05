<?php

namespace App\Services\OrderService\Jobs\V1\Common;

use App\Services\OrderService\Models\OrderLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SetAddressForOrderLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly OrderLocation $orderLocation)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tries = 10;

        while ($tries) {
            $map_response = Http::withHeaders(['x-api-key' => env('MAP_KEY')])
                ->get(env('MAP_URL') . "reverse?lat=" . $this->orderLocation->latitude . "&lon=" . $this->orderLocation->longitude);

            if ($map_response->successful()) {
                $map_response = $map_response->json('address');

                if ($map_response) {
                    $this->orderLocation->update([
                        'address' => $map_response,
                    ]);
                }

                break;
            }
            else {
                $tries--;
                sleep(2);
            }
        }
    }
}
