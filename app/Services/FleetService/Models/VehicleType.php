<?php

namespace App\Services\FleetService\Models;

use App\Services\FleetService\Enumerations\V1\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $title
 */
class VehicleType extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => VehicleStatus::class
    ];

    protected $fillable = [
        'id',
        'title'
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
