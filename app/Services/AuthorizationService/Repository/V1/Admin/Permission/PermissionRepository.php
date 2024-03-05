<?php

namespace App\Services\AuthorizationService\Repository\V1\Admin\Permission;

use App\Services\AuthorizationService\Models\Permission;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissionRepository extends BaseRepository implements PermissionInterface
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    public function conditions(Builder $query): array
    {
        return [
            'name'  => fn($value) => $query->where('name', 'like', "%$value%"),
            'title' => fn($value) => $query->where('title', 'like', "%$value%"),
        ];
    }

    public function store(array $parameters): Model
    {
        DB::beginTransaction();

        /** @var Permission $permission */
        $permission = parent::store($parameters);

        if (isset($parameters['roles'])) {
            $permission->roles()->sync($parameters['roles']);
        }

        DB::commit();

        return $permission->refresh();
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        /** @var Permission $model */
        $model = parent::update($model, $parameters);

        if (isset($parameters['roles'])) {
            $model->roles()->sync($parameters['roles']);
        }

        DB::commit();

        return $model->refresh();
    }

    public function destroy(Model $model): bool
    {
        /** @var Permission $model */
        $model->users()->detach();
        $model->roles()->detach();

        return parent::destroy($model);
    }
}
