<?php

namespace App\Services\OrderService\Resources\V1\Common\Order;

use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Resources\V1\Common\Driver\BriefDriverResource;
use App\Services\OrderService\Resources\V1\Common\OrderItem\OrderItemResource;
use App\Services\OrderService\Resources\V1\Common\OrderLocation\OrderLocationResource;
use App\Services\OrderService\Resources\V1\Common\OrderStatus\BriefOrderStatusResource;
use App\Services\OrderService\Resources\V1\Common\OrderStatusLog\OrderStatusLogResource;
use App\Services\OrderService\Resources\V1\Common\Vehicle\VehicleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */

        $data = parent::toArray($request);
        $data['last_status'] = null;
        $data['driver'] = null;
        $data['vehicle'] = null;

        if (isset($this->last_status_id)) {
            $data['last_status'] = new BriefOrderStatusResource($this->lastStatus);
            unset($data['last_status_id']);
        }
        if (isset($this->driver_id)) {
            $data['driver'] = new BriefDriverResource($this->driver);
            unset($data['driver_id']);
        }
        if (isset($this->vehicle_id)) {
            $data['vehicle'] = new VehicleResource($this->vehicle);
            unset($data['vehicle_id']);
        }

        $data['items'] = OrderItemResource::collection($this->items);
        $data['status_logs'] = OrderStatusLogResource::collection($this->statusLogs);
        $data['pick_ups'] = OrderLocationResource::collection($this->pick_ups);
        $data['drop_offs'] = OrderLocationResource::collection($this->drop_offs);
        $data['picked_up'] = is_null($this->current_pick_up);

        return $data;
    }
}
