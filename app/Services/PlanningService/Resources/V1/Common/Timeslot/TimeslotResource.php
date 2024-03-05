<?php

namespace App\Services\PlanningService\Resources\V1\Common\Timeslot;

use App\Services\PlanningService\Models\Timeslot;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeslotResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Timeslot $this */
        return [
            'id'        => $this->id,
            'starts_at' => $this->starts_at,
            'ends_at'   => $this->ends_at,
            'status'    => $this->status,
        ];
    }
}
