<?php

namespace App\Services\PlanningService\Resources\V1\Common\Schedule;

use App\Services\PlanningService\Models\Schedule;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Schedule $this */
        return [
            'id'                => $this->id,
            'date'              => $this->date->format('Y-m-d H:i:s'),
            'timeslot'          => $this->timeslot->only('id', 'starts_at', 'ends_at'),
            'vehicle_type'      => $this->vehicleType->only('id', 'title'),
            'capacity'          => $this->capacity,
            'used_capacity'     => $this->used_capacity,
            'reserved_capacity' => $this->reserved_capacity,
            'vehicles_count'    => $this->vehicles_count,
            'status'            => $this->status,
        ];
    }
}
