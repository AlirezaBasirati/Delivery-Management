<?php

namespace App\Services\OrderService\Resources\V2\Driver\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Resources\V1\Driver\OrderLocation\OrderLocationResource;
use App\Services\OrderService\Resources\V1\Driver\OrderStatus\OrderStatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */

        $driver = $this->driver;
        $current_pick_up = $this->current_pick_up;
        $returned = $this->statusLogs()
            ->whereIn('order_status_id', [OrderStatus::PARTIAL_RETURN, OrderStatus::COMPLETE_RETURN, OrderStatus::ABSENCE_OF_RECEIVER])
            ->exists();

        if ($returned) {
            $pick_up = $this->last_drop_off;
        }
        else {
            $pick_up = $current_pick_up ?? $this->last_pick_up;
        }

        return [
            'id'                          => $this->id,
            'delivery_code'               => $this->delivery_code,
            'code'                        => $this->code,
            'last_status'                 => new OrderStatusResource($this->lastStatus),
            'next_status'                 => new OrderStatusResource($this->next_status),
            'parcel_value'                => $this->parcel_value,
            'price'                       => $this->price,
            'cod_amount'                  => $this->cod_amount,
            'package_quantity'            => $this->package_quantity,
            'duration_to_next_location'   => $driver->duration_to_next_location / 60,
            'distance_from_next_location' => $driver->distance_from_next_location / 1000,
            'picked_up'                   => is_null($current_pick_up),
            'returned'                    => $returned,
            'pick_up'                     => new OrderLocationResource($pick_up),
            'drop_offs'                   => OrderLocationResource::collection($this->drop_offs),
            'permissions'                 => $this->permissions,
            'created_at'                  => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
