<?php

namespace App\Services\MessageService\Resources\V1\Common\StaticMessage;

use App\Services\MessageService\Models\StaticMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin StaticMessage */
class BriefStaticMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'message' => $this->message,
        ];
    }
}
