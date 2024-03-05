<?php

namespace App\Services\MessageService\Resources\V1\Common\Ticket;

use App\Services\MessageService\Models\Ticket;
use App\Services\MessageService\Resources\V1\Common\StaticMessage\BriefStaticMessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Ticket */
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'order_id'       => $this->order_id,
            'status'         => $this->status,
            'static_message' => new BriefStaticMessageResource($this->staticMessage),
            'type'           => $this->type,
            'created_at'     => $this->created_at->format('y-m-d H:i:s'),
            'updated_at'     => $this->updated_at->format('y-m-d H:i:s'),
        ];
    }
}
