<?php

namespace App\Services\OrderService\Resources\V1\Common\User;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 */
class BriefUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
        ];
    }
}
