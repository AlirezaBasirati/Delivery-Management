<?php

namespace App\Services\PlanningService\Resources\V1\Common\Template;

use App\Services\PlanningService\Models\Template;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexTemplateResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Template $this */
        return [
            'id'   => $this->id,
            'name' => $this->name
        ];
    }
}
