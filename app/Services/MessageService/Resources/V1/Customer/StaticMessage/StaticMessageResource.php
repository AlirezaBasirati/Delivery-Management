<?php

namespace App\Services\MessageService\Resources\V1\Customer\StaticMessage;

use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property StaticMessageGroup $group
 * @property string $title
 * @property string $message
 */
class StaticMessageResource extends JsonResource
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
