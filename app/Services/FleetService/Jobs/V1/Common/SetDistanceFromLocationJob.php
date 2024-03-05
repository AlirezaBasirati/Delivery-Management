<?php

namespace App\Services\FleetService\Jobs\V1\Common;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\OrderLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SetDistanceFromLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Driver $driver, private readonly OrderLocation $location)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tries = 5;

        while ($tries) {
            try {
                $map_response = Http::withHeaders(['x-api-key' => env('MAP_KEY')])
                    ->get(env('MAP_URL') . "eta/driving/" . $this->driver->longitude . "," . $this->driver->latitude . ";" . $this->location->longitude . "," . $this->location->latitude);

                if ($map_response->successful()) {
                    $map_response = $map_response->json('routes');

                    if ($map_response) {
                        $this->driver->update([
                            'distance_from_next_location' => $map_response['distance'],
                            'duration_to_next_location'   => $map_response['duration']
                        ]);

                        break;
                    }
                    else {
                        $tries--;
                        continue;
                    }
                }
                else {
                    $tries--;
                    continue;
                }
            }
            catch (\Exception $exception) {
                $tries--;
                continue;
            }
        }
    }
}
