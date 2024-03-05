<?php

namespace App\Services\FleetService\Resources\V1\Common\OrderStatus;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $name
 */
class OrderStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'name'  => $this->name
        ];
    }
}
