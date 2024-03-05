<?php

namespace App\Services\OrderService\Resources\V2\Driver\Order;

use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Resources\V1\Common\OrderState\OrderStateResource;
use App\Services\OrderService\Resources\V1\Driver\OrderLocation\BriefOrderLocationResource;
use App\Services\OrderService\Resources\V1\Driver\OrderLocation\OrderLocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BriefOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */

        $un_assigned = $this->unAssignedOrders()->where('driver_id', $request->user()->driver->id)->first();
        $last_status = $un_assigned ? $un_assigned->statusLog->orderStatus : $this->lastStatus;

        return [
            'id'            => $this->id,
            'delivery_code' => $this->delivery_code,
            'code'          => $this->code,
            'last_state'    => new OrderStateResource($last_status->state),
            'cod_amount'    => $this->cod_amount,
            'pick_up'       => new BriefOrderLocationResource($this->pick_ups->first()),
            'drop_offs'     => OrderLocationResource::collection($this->drop_offs),
            'created_at'    => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
