<?php

namespace App\Services\FileService\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @property string $id
 * @property string $path
 * @property string $description
 * @property int $size
 * @property string $extension
 */
class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'path',
        'description',
        'size',
        'extension',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
