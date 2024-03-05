<?php

namespace App\Services\CustomerService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 */
class Bookmark extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'name',
        'latitude',
        'longitude',
        'address',
    ];
}
