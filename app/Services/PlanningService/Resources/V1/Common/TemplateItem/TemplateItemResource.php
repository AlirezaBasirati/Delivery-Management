<?php

namespace App\Services\PlanningService\Resources\V1\Common\TemplateItem;

use App\Services\PlanningService\Models\TemplateItem;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateItemResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var TemplateItem $this */
        return [
            'id'          => $this->id,
            'day_of_week' => $this->day_of_week,
            'timeslot'    => $this->timeslot->only('id', 'starts_at', 'ends_at', 'status'),
            'capacity'    => $this->capacity
        ];
    }
}
