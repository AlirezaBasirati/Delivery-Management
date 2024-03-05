<?php

namespace App\Services\MessageService\Repository\V1\Common\Ticket;

use App\Services\MessageService\Enumerations\V1\TicketStatus;
use App\Services\MessageService\Models\Ticket;
use App\Services\MessageService\Repository\V1\Common\TicketMessage\TicketMessageInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TicketRepository extends BaseRepository implements TicketInterface
{
    public function __construct(private readonly TicketMessageInterface $ticketMessage, Ticket $model)
    {
        parent::__construct($model);
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $user = auth()->user();

        $query->where('user_id', $user->id);

        return parent::query($query, $parameters);
    }

    public function store(array $parameters): Model
    {
        $user = auth()->user();

        $parameters['user_id'] = $user->id;
        $parameters['status'] = TicketStatus::ANSWER_PENDING->value;

        \DB::beginTransaction();
        /** @var Ticket $ticket */
        $ticket = parent::store($parameters);

        $parameters['ticket_id'] = $ticket->id;
        $this->ticketMessage->store($parameters);

        \DB::commit();
        return $ticket;
    }
}
