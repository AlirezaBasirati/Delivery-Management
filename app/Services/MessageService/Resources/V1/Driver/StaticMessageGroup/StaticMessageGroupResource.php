<?php

namespace App\Services\MessageService\Resources\V1\Driver\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessage;
use App\Services\MessageService\Resources\V1\Driver\StaticMessage\BriefStaticMessageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property boolean $reserve
 * @property Collection<StaticMessage> $messages
 */
class StaticMessageGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'name'     => $this->name,
            'messages' => BriefStaticMessageResource::collection($this->messages)
        ];
    }
}
