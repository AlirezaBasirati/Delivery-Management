<?php

namespace App\Services\OrderService\Resources\V1\Driver\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Resources\V1\Driver\OrderLocation\OrderLocationResource;
use App\Services\OrderService\Resources\V1\Driver\OrderStatus\OrderStatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduledOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */
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
            'id'                => $this->id,
            'delivery_code'     => $this->delivery_code,
            'code'              => $this->code,
            'start_of_schedule' => $this->start_of_schedule,
            'last_status'       => new OrderStatusResource($this->lastStatus),
            'next_status'       => new OrderStatusResource($this->next_status),
            'parcel_value'      => $this->parcel_value,
            'price'             => $this->price,
            'cod_amount'        => $this->cod_amount,
            'package_quantity'  => $this->package_quantity,
            'pick_up'           => new OrderLocationResource($pick_up),
            'drop_offs'         => OrderLocationResource::collection($this->drop_offs),
            'permissions'       => $this->permissions,
            'timeslot'          => $this->schedule?->timeslot?->only('id', 'starts_at', 'ends_at'),
            'created_at'        => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
