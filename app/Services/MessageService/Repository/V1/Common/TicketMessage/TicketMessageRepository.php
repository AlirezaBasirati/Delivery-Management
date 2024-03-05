<?php

namespace App\Services\MessageService\Repository\V1\Common\TicketMessage;

use App\Services\MessageService\Enumerations\V1\TicketStatus;
use App\Services\MessageService\Enumerations\V1\TicketType;
use App\Services\MessageService\Models\Ticket;
use App\Services\MessageService\Models\TicketMessage;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TicketMessageRepository extends BaseRepository implements TicketMessageInterface
{
    public function __construct(
        private readonly TicketMessage $ticketMessage,
        private readonly Ticket        $ticket
    )
    {
        parent::__construct($this->ticketMessage);
    }

    public function query(Builder $query, array $parameters): Builder
    {
        if (isset($parameters['ticket_id'])) {
            $query->where('ticket_id', $parameters['ticket_id']);
        }

        return parent::query($query, $parameters);
    }

    public function messages(Ticket $ticket): LengthAwarePaginator|Collection
    {
        $parameters = ['ticket_id' => $ticket->id];

        return $this->index($parameters);
    }

    public function store(array $parameters): Model
    {
        $user = auth()->user();


        $parameters['user_id'] = $user->id;

        if ($parameters['type'] === TicketType::ADMIN->value) {
            $parameters['status'] = TicketStatus::ANSWERED->value;
        } else {
            $parameters['status'] = TicketStatus::ANSWER_PENDING->value;
        }

        \DB::beginTransaction();

        $this->ticket->query()
            ->where('id', $parameters['ticket_id'])
            ->update(['status' => $parameters['status']]);

        $ticketMessage = parent::store($parameters);

        \DB::commit();

        return $ticketMessage;
    }
}
