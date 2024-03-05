<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\User;

use App\Services\AuthenticationService\Models\User;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        return parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'username' => fn($value) => $query->where('username', 'LIKE', "%$value%"),
            'role_id'  => '=',
        ];
    }

    public function store(array $parameters): Model
    {
        if (isset($parameters['role'])) {
            $parameters['role_id'] = $parameters['role'];
            unset($parameters['role']);
        }

        /** @var User $user */
        return parent::store($parameters);
    }

    public function update(Model $model, array $parameters): Model
    {
        if (isset($parameters['role'])) {
            $parameters['role_id'] = $parameters['role'];
            unset($parameters['role']);
        }

        return parent::update($model, $parameters);
    }

    public function destroy(Model $model): bool
    {
        /** @var User $model */
        if ($driver = $model->driver) {
            $driver->delete();
        }

        return parent::destroy($model);
    }
}
