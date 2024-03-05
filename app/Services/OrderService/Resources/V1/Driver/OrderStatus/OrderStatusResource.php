<?php

namespace App\Services\OrderService\Resources\V1\Driver\OrderStatus;

use App\Services\OrderService\Models\OrderState;
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
 */
class OrderStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'name'  => $this->name,
            'state' => new OrderStateResource($this->state),
        ];
    }
}
