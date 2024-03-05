<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Role;

use App\Services\AuthorizationService\Models\Role;
use App\Services\AuthorizationService\Repository\V1\Admin\Permission\PermissionInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function __construct(Role $role, private readonly PermissionInterface $permissionService)
    {
        parent::__construct($role);
    }

    public function conditions(Builder $query): array
    {
        return [
            'name'   => fn($value) => $query->where('name', 'like', "%$value%"),
            'title'  => fn($value) => $query->where('title', 'like', "%$value%"),
            'status' => fn($value) => $query->where('status', $value),
        ];
    }

    public function store($parameters): Model
    {
        DB::beginTransaction();

        /** @var Role $role */
        $role = parent::store($parameters);

        $this->assignPermissions($role, $parameters);

        DB::commit();

        return $role->refresh();
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        /** @var Role $model */
        $model = parent::update($model, $parameters);

        $this->assignPermissions($model, $parameters);

        DB::commit();

        return $model->refresh();
    }

    public function assignPermissions(Role $role, array $parameters): void
    {
        if (isset($parameters['permissions']['all']) && $parameters['permissions']['all']) {
            $permissions = $this->permissionService->index(['paginate' => false], ['id'])->pluck('id')->toArray();
            $role->permissions()->sync($permissions);
        }

        if (isset($parameters['permissions']['only'])) {
            $role->permissions()->sync($parameters['permissions']['only']);
        }

        if (isset($parameters['permissions']['except'])) {
            $role->permissions()->detach($parameters['permissions']['except']);
        }

        if (isset($parameters['permissions']['append'])) {
            $role->permissions()->syncWithoutDetaching($parameters['permissions']['append']);
        }
    }
}
