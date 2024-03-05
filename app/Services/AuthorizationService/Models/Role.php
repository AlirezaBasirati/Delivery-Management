<?php

namespace App\Services\AuthorizationService\Models;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthorizationService\Traits\V1\Permissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


/**
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property Collection $permissions
 * @property Collection $users
 */
class Role extends Model
{
    protected $fillable = ['name', 'title', 'status'];

    public $timestamps = false;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_roles',
            'role_id',
            'permission_id'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function refreshCache(): void
    {
        /** @var Permissions $user */
        foreach ($this->users as $user) {
            $key = "role.$this->id";
            if(Cache::has($key)) {
                $user->cacheRole(true);
            }
        }
    }

    /**
     * @param array $names
     * @param bool $throw
     * @return array
     */
    public static function getIds(array $names, bool $throw = true): array
    {
        $items = static::query()
            ->whereIn('name', $names)
            ->select(['id', 'name'])
            ->pluck('id', 'name')
            ->toArray();

        if(count($items) === count($names) || !$throw) {
            return array_values($items);
        }

        $notExists = array_diff($names, array_keys($items));
        throw new ModelNotFoundException('Not found roles name ' . implode(', ', $notExists));
    }
}
