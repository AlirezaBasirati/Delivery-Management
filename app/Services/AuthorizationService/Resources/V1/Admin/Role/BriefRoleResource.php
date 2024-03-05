<?php

namespace App\Services\AuthorizationService\Resources\V1\Admin\Role;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property boolean $status
 */
class BriefRoleResource extends JsonResource
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
