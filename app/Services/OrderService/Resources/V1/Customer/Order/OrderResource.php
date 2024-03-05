<?php

namespace App\Services\OrderService\Resources\V1\Customer\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderStatusLog;
use App\Services\OrderService\Resources\V1\Common\Driver\BriefDriverResource;
use App\Services\OrderService\Resources\V1\Common\Vehicle\VehicleResource;
use App\Services\OrderService\Resources\V1\Customer\OrderLocation\BriefOrderLocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */
        $assigned = OrderStatusLog::query()
            ->where('order_id', $this->id)
            ->where('order_status_id', OrderStatus::ASSIGNED->value)
            ->first();

        $status = $this->lastStatus;

        return [
            'id'            => $this->id,
            'delivery_code' => $this->delivery_code,
            'pick_up'       => new BriefOrderLocationResource($this->pick_ups->first()),
            'drop_offs'     => BriefOrderLocationResource::collection($this->drop_offs),
            'driver'        => new BriefDriverResource($this->driver),
            'vehicle'       => new VehicleResource($this->vehicle),
            'assigned_at'   => $assigned?->created_at->format('Y-m-d H:i:s'),
            'state'         => $status->state->only('id', 'name', 'title'),
            'status'        => $status->only('id', 'name', 'title'),
        ];
    }
}
