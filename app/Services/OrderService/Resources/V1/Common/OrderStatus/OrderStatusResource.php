<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderStatus;

use App\Services\OrderService\Models\OrderState;
use App\Services\OrderService\Models\OrderStatus;
use App\Services\OrderService\Resources\V1\Common\OrderState\OrderStateResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $name
 * @property boolean $for_driver
 * @property boolean $reserve
 * @property integer $sort
 * @property Collection<OrderState> $state
 * @property OrderStatus $nextStatus
 */
class OrderStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'title'       => $this->title,
            'name'        => $this->name,
            'for_driver'  => $this->for_driver,
            'reserve'     => $this->reserve,
            'sort'        => $this->sort,
            'state'       => new OrderStateResource($this->state),
            'next_status' => new BriefOrderStatusResource($this->nextStatus)
        ];
    }
}
