<?php

namespace App\Services\OrderService\Resources\V1\Customer\Order;

use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderStatusLog;
use App\Services\OrderService\Resources\V1\Customer\OrderLocation\BriefOrderLocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 */
class BriefOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */
        $arrived = OrderStatusLog::query()
            ->where('order_id', $this->id)
            ->where('order_status_id', OrderStatus::PICKED_UP->value)
            ->first();

        return [
            'id'                 => $this->id,
            'delivery_code'      => $this->delivery_code,
            'code'               => $this->code,
            'pick_up_arrived_at' => $arrived?->created_at->format('Y-m-d H:i:s'),
            'pick_ups'           => BriefOrderLocationResource::collection($this->pick_ups),
            'drop_offs'          => BriefOrderLocationResource::collection($this->drop_offs),
            'state'              => $this->lastStatus->state->only('id', 'name', 'title'),
            'created_at'         => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
