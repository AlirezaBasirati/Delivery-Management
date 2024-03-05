<?php

namespace App\Services\AuthenticationService\Models;

use App\Services\AuthenticationService\Database\Factories\UserFactory;
use App\Services\AuthorizationService\Traits\V1\Permissions;
use App\Services\CustomerService\Models\Customer;
use App\Services\FleetService\Models\Driver;
use App\Services\AuthorizationService\Models\Permission;
use App\Services\TenantService\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property Collection<Permission> $permissions
 * @property integer $role_id
 * @property integer $tenant_id
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 * @property string $national_code
 * @property string $password
 * @property integer $type
 * @property integer $status
 * @property boolean $is_blocked
 * @property Carbon $birth_date
 *
 * @property string $full_name
 * @property Driver $driver
 * @property Customer $customer
 * @property Tenant $tenant
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Permissions;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'tenant_id',
        'role_id',
        'email',
        'first_name',
        'last_name',
        'national_code',
        'mobile',
        'password',
        'birth_date',
        'is_blocked',
        'status',
    ];

    protected $hidden = [
        'password'
    ];

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => trim($value) != '' ? Hash::make(trim($value)) : null,
        );
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'notification.user.'.$this->id;
    }

    /**
     * Find the user instance for the given username.
     */
    public function findForPassport(string $username): Model
    {
        return $this->query()->where('username', $username)->first();
    }

    public function getFullNameAttribute(): string
    {
        return "$this->first_name $this->last_name";
    }

    public function driver(): HasOne|null
    {
        return $this->hasOne(Driver::class);
    }

    public function customer(): HasOne|null
    {
        return $this->hasOne(Customer::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
