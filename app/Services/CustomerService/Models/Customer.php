<?php

namespace App\Services\CustomerService\Models;

use App\Services\AuthenticationService\Models\User;
use App\Services\TenantService\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $tenant_id
 * @property int $type
 * @property string $balance
 * @property string $phone
 * @property string $address
 * @property string $verification_code
 * @property string $verified_mobile
 * @property Carbon $verified_at
 * @property User $user
 * @property Tenant $tenant
 */
class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'type',
        'balance',
        'phone',
        'address',
        'verification_code',
        'verified_mobile',
        'verified_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
