<?php

namespace App\Services\AuthorizationService\Resources\V1\Admin\Role;

use App\Services\AuthorizationService\Models\Permission;
use App\Services\AuthorizationService\Resources\V1\Admin\Permission\BriefPermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $title
 * @property boolean $status
 * @property Collection<Permission> $permissions
 */
class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'title'       => $this->title,
            'status'      => $this->status,
            'permissions' => BriefPermissionResource::collection($this->permissions)
        ];
    }
}
