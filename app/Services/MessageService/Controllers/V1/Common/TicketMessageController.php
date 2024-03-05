<?php

namespace App\Services\MessageService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Models\Ticket;
use App\Services\MessageService\Repository\V1\Common\TicketMessage\TicketMessageInterface;
use App\Services\MessageService\Requests\V1\Common\TicketMessage\StoreRequest;
use App\Services\MessageService\Resources\V1\Common\TicketMessage\TicketMessageResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class TicketMessageController extends Controller
{
    public function __construct(private readonly TicketMessageInterface $ticketMessage)
    {
    }

    public function messages(Ticket $ticket): JsonResponse
    {
        $messages = $this->ticketMessage->messages($ticket);

        return Responser::collection(TicketMessageResource::collection($messages));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->ticketMessage->store($request->validated());

        return Responser::success();
    }
}
