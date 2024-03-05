<?php

namespace App\Services\FleetService\Resources\V1\Common\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class MapResource extends JsonResource
{
    public function toArray($request): array
    {
        $order = $this->currentOrder;

        return [
            'id'           => $this->id,
            'user'         => $this->user->only('id', 'full_name'),
            'latitude'     => $this->latitude,
            'longitude'    => $this->longitude,
            'is_free'      => $this->is_free,
            'status'       => $this->status,
            'order_status' => $order ? $order?->lastStatus?->only('id', 'name') : null
        ];
    }
}
