<?php

namespace App\Services\MessageService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Models\Ticket;
use App\Services\MessageService\Repository\V1\Common\Ticket\TicketInterface;
use App\Services\MessageService\Requests\V1\Common\Ticket\StoreRequest;
use App\Services\MessageService\Resources\V1\Common\Ticket\TicketResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private readonly TicketInterface $ticketRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $tickets = $this->ticketRepository->index($request->all());

        return Responser::collection(TicketResource::collection($tickets));
    }

    public function show(Ticket $ticket): JsonResponse
    {
        $ticket = $this->ticketRepository->show($ticket);

        return Responser::info(new TicketResource($ticket));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $ticket = $this->ticketRepository->store($request->validated());

        return Responser::success(new TicketResource($ticket));
    }
}
