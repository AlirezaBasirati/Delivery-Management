<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderState;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $name
 */
class OrderStateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'name'  => $this->name,
        ];
    }
}
