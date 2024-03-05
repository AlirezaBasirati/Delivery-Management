<?php

namespace App\Services\AuthorizationService\Traits\V1;

use App\Services\AuthorizationService\Enumerations\V1\RoleStatus;
use App\Services\AuthorizationService\Models\Permission;
use App\Services\AuthorizationService\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * @property integer $id
 * @property Role $role
 * @property Collection $permissions
 */
trait Permissions
{
    /**
     * Get roles of user
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get list roles user
     * @return array
     */
    public function allowsRoles(): array
    {
        return $this->role()->where('roles.status', RoleStatus::ACTIVE)->pluck('name')->toArray();
    }

    /**
     * Cache roles user
     * @param bool $force
     * @return array
     */
    public function cacheRole(bool $force = false): array
    {
        $key = "role.$this->id";
        if ($force) {
            Cache::forget($key);
        }
        return Cache::store(env('PERMISSION_CACHE_DRIVER', env('CACHE_DRIVER')))
            ->remember(
                $key,
                env('PERMISSION_CACHE_LIFETIME', 60),
                fn() => $this->allowsRoles()
            );
    }

    /**
     * Check access role user
     * @param ...$names
     * @return bool
     */
    public function hasRoles(...$names): bool
    {
        return (bool)count(array_intersect($names, $this->cacheRole()));
    }

    /**
     * Check access just role user
     * @param string $name
     * @return bool
     */
    public function onlyRole(string $name): bool
    {
        $roles = $this->cacheRole();
        return count($roles) === 1 && current($roles) === $name;
    }

    /**
     * Get permissions user
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_users',
            'user_id',
            'permission_id'
        )
            ->withPivot(['is_able']);
    }

    /**
     * Get list permissions of user
     * @return array
     */
    public function allowsPermissions(): array
    {
        $permissions = collect();
        $withRoles = $this->load('role.permissions');
        /** @var self $withRoles */
        foreach ($withRoles->role->permissions as $permission) {
            if (!$permissions->contains('id', $permission->id)) {
                $permissions->push($permission->only($permission->getFillable()));
            }
        }

        if ($this->permissions()->count()) {
            $extra = $this->permissions()->where('is_able', 1)->get();
            foreach ($extra as $permission) {
                if (!$permissions->contains('id', $permission->id)) {
                    $permissions->push($permission->only($permission->getFillable()));
                }
            }

            $reduction = $this->permissions()->where('is_able', 0)->pluck('id')->toArray();

            $permissions = $permissions->whereNotIn('id', [$reduction]);
        }
        return $permissions->toArray();
    }

    /**
     * Cache permissions user
     * @param bool $force
     * @return array
     */
    public function cachePermissions(bool $force = false): array
    {
        $key = "permission.$this->id";
        if ($force) {
            Cache::forget($key);
        }
        return Cache::store(env('PERMISSION_CACHE_DRIVER', env('CACHE_DRIVER')))
            ->remember(
                $key,
                env('PERMISSION_CACHE_LIFETIME', 60),
                fn() => $this->allowsPermissions()
            );
    }

    /**
     * Assign permissions user
     * @param array $names
     * @return array
     */
    public function attachPermissions(array $names): array
    {
        return $this->attachPermissionsById(Role::getIds($names));
    }

    /**
     * Assign permissions user
     * @param array $ids
     * @return array
     */
    public function attachPermissionsById(array $ids): array
    {
        $this->permissions()->syncWithoutDetaching($ids);

        return $this->cachePermissions(true);
    }

    /**
     * Detach permissions  user
     * @param array $names
     * @return array
     */
    public function detachPermissions(array $names): array
    {
        return $this->detachPermissionsById(Permission::getIds($names));
    }

    /**
     * Detach permissions user
     * @param array $ids
     * @return array
     */
    public function detachPermissionsById(array $ids): array
    {
        $this->permissions()->detach($ids);

        return $this->cachePermissions(true);
    }

    /**
     * Check access permissions for user
     *
     * @param ...$names
     * @return bool
     */
    public function hasPermissions(...$names): bool
    {
        $allows = array_map(fn($permission) => $permission['name'], $this->cachePermissions());
        return (bool)count(array_intersect($names, $allows));
    }
}
