<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderStatus;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $name
 */
class BriefOrderStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'code'  => $this->code,
            'title' => $this->title,
            'name'  => $this->name,
        ];
    }
}
