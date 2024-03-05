<?php

namespace App\Services\MessageService\Resources\V1\Common\StaticMessageGroup;

use App\Services\MessageService\Models\StaticMessageGroup;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property StaticMessageGroup $parent
 * @property string $title
 * @property string $name
 * @property boolean $reserve
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class StaticMessageGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'parent'     => new StaticMessageGroupResource($this->parent),
            'title'      => $this->title,
            'name'       => $this->name,
            'reserve'    => $this->reserve,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
