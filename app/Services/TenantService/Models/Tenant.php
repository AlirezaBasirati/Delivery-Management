<?php

namespace App\Services\TenantService\Models;

use App\Services\TenantService\Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $phone
 * @property string $webhook_url
 */
class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'name',
        'phone',
        'webhook_url',
    ];

    protected static function newFactory(): Factory
    {
        return TenantFactory::new();
    }
}
