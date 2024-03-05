<?php

namespace App\Services\MessageService\Resources\V1\Common\StaticMessage;

use App\Services\MessageService\Models\StaticMessageGroup;
use App\Services\MessageService\Resources\V1\Driver\StaticMessageGroup\BriefStaticMessageGroupResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property StaticMessageGroup $group
 * @property string $title
 * @property string $message
 * @property string $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class StaticMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'group'      => new BriefStaticMessageGroupResource($this->group),
            'title'      => $this->title,
            'message'    => $this->message,
            'is_active'  => $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
