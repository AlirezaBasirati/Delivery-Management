<?php

namespace App\Services\MessageService\Enumerations\V1;

enum TicketStatus: string
{
    case CLOSED = 'closed';

    case ANSWERED = 'answered';

    case ANSWER_PENDING = 'answer_pending';
}
