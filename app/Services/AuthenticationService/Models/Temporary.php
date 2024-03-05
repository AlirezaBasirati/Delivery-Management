<?php

namespace App\Services\AuthenticationService\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    use HasFactory;

    protected $casts = [
        'send_at' => 'datetime'
    ];

    protected $fillable = [
        'mobile',
        'email',
        'code',
        'retries',
        'send_at',
    ];
}
