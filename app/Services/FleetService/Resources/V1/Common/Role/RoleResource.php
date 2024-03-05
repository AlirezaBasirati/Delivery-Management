<?php

namespace App\Services\FleetService\Resources\V1\Common\Role;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property boolean $status
 */
class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'title' => $this->title,
            'status' => $this->status,
        ];
    }
}
