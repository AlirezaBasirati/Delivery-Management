<?php

namespace App\Services\OrderService\Resources\V1\Common\Order;

use App\Services\OrderService\Resources\V1\Common\Driver\ShowDriverOnMapResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderOnMapResource extends JsonResource
{
    public function toArray($request): array
    {
        $pick_up = $this->current_pick_up ?? $this->last_pick_up;
        $drop_off = $this->current_drop_off ?? $this->last_drop_off;

        $driver = $this->driver;

//        if ($this->last_status_id == OrderStatus::PENDING->value) {
//            $broadcast_drivers = resolve(DriverInterface::class)->index(['paginate' => false, 'broadcast_order_id' => $this->id]);
//            $parameters['drivers'] = MapResource::collection($broadcast_drivers);
//        }

        return [
            'id'       => $this->id,
            'pick_up'  => $pick_up->only('id', 'latitude', 'longitude'),
            'drop_off' => $drop_off->only('id', 'latitude', 'longitude'),
            'driver' => $driver && $this->is_processing ? new ShowDriverOnMapResource($driver) : null
        ];
    }
}
