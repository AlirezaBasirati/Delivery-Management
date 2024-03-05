<?php

namespace App\Services\OrderService\Resources\V2\Dispatcher\Order;

use App\Services\OrderService\Enumerations\V1\OrderState;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Resources\V1\Common\Driver\BriefDriverResource;
use App\Services\OrderService\Resources\V1\Common\OrderLocation\BriefOrderLocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BriefOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Order $this */

        $last_state = $this->lastStatus->state_id;
        $assign_permission = !in_array($last_state, [OrderState::DONE->value, OrderState::CANCELED->value]);

        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'pick_up'     => new BriefOrderLocationResource($this->current_pick_up ?? $this->last_pick_up),
            'drop_offs'   => BriefOrderLocationResource::collection($this->drop_offs),
            'driver'      => $this->is_processing ? new BriefDriverResource($this->driver) : null,
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
            'picked_up'   => is_null($this->current_pick_up),
            'permissions' => [
                'assign_driver'    => $assign_permission,
                'un_assign_driver' => isset($this->driver_id) && $assign_permission,
                'broadcast'        => $last_state == OrderState::UNASSIGNED->value
            ]
        ];
    }
}
