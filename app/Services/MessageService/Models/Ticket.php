<?php

namespace App\Services\MessageService\Models;

use App\Services\AuthenticationService\Models\User;
use App\Services\MessageService\Enumerations\V1\TicketStatus;
use App\Services\MessageService\Enumerations\V1\TicketType;
use App\Services\OrderService\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $order_id
 * @property TicketStatus $status
 * @property int $static_message_id
 * @property int $user_id
 * @property TicketType $type
 * @property User $user
 * @property Order $order
 * @property StaticMessage $staticMessage
 * @property Collection<TicketMessage> $messages
 */
class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'status',
        'static_message_id',
        'user_id',
        'type',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'type'   => TicketType::class
    ];

    public function staticMessage(): BelongsTo
    {
        return $this->belongsTo(StaticMessage::class);
    }
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }
}
