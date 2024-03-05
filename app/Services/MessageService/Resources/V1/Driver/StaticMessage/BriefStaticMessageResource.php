<?php

namespace App\Services\MessageService\Resources\V1\Driver\StaticMessage;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $message
 */
class BriefStaticMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'message' => $this->message,
        ];
    }
}
