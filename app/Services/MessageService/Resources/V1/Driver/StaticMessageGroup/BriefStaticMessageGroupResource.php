<?php

namespace App\Services\MessageService\Resources\V1\Driver\StaticMessageGroup;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 */
class BriefStaticMessageGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title
        ];
    }
}
