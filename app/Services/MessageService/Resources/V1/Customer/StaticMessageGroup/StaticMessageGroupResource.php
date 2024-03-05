<?php

namespace App\Services\MessageService\Resources\V1\Customer\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessageGroup;
use App\Services\MessageService\Resources\V1\Driver\StaticMessage\BriefStaticMessageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticMessageGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var StaticMessageGroup $this */
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'name'     => $this->name,
            'messages' => BriefStaticMessageResource::collection($this->messages),
            'parent'   => new BriefStaticMessageGroupResource($this->parent),
            'children' => BriefStaticMessageGroupResource::collection($this->children),
        ];
    }
}
