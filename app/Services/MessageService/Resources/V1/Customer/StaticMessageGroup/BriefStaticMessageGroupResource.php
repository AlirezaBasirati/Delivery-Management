<?php

namespace App\Services\MessageService\Resources\V1\Customer\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 */
class BriefStaticMessageGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var StaticMessageGroup $this */
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'is_parent' => $this->children()->count() > 0
        ];
    }
}
