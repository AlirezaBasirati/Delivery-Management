<?php

namespace App\Services\MessageService\Repository\V1\Common\TicketMessage;

use App\Services\MessageService\Models\Ticket;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface TicketMessageInterface extends BaseRepositoryInterface
{
    public function messages(Ticket $ticket);
}
