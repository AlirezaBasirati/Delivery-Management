<?php

namespace App\Services\AuthorizationService\Resources\V1\Admin\Permission;

use App\Services\AuthorizationService\Models\Role;
use App\Services\AuthorizationService\Resources\V1\Admin\Role\BriefRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property Collection<Role> $roles
 */
class PermissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'roles' => BriefRoleResource::collection($this->roles)
        ];
    }
}
