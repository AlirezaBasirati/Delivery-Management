<?php

namespace App\Services\OrderService\Resources\V1\Customer\OrderLocation;

use App\Services\OrderService\Models\OrderLocation;
use Illuminate\Http\Resources\Json\JsonResource;

class BriefOrderLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var OrderLocation $this */

        return [
            'id'           => $this->id,
            'latitude'     => $this->latitude,
            'longitude'    => $this->longitude,
            'address'      => $this->address,
            'name'         => $this->name,
            'sort'         => $this->sort,
            'delivered_at' => $this->delivered_at,
        ];
    }
}
