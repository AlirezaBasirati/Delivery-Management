<?php

namespace App\Services\OrderService\Resources\V1\Tenant\Order;

use App\Services\OrderService\Resources\V1\Common\OrderStatusLog\OrderStatusLogResource;
use App\Services\OrderService\Resources\V1\Common\Vehicle\VehicleResource;
use App\Services\OrderService\Resources\V1\Tenant\Driver\DriverLocationResource;
use App\Services\OrderService\Resources\V1\Tenant\Driver\DriverResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        $driver = $this->driver;

        return [
            'id' => $this->id,
            'driver' => new DriverResource($driver),
            'vehicle' => new VehicleResource($this->vehicle),
            'driver_location' => $this->is_processing ? new DriverLocationResource($driver) : null,
            'picked_at' => $this->last_pick_up?->delivered_at,
            'dropped_at' => $this->last_drop_off?->delivered_at,
            'status_logs' => OrderStatusLogResource::collection($this->statusLogs),
        ];
    }
}
