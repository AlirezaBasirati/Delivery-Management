<?php

namespace App\Services\MessageService\Models;

use App\Services\AuthenticationService\Models\User;
use App\Services\MessageService\Enumerations\V1\TicketType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $ticket_id
 * @property int $user_id
 * @property TicketType $type
 * @property string $message
 * @property Ticket $ticket
 * @property User $user
 */
class TicketMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'type',
        'message'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
