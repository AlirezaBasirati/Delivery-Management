<?php

namespace App\Services\OrderService\Resources\V1\Common\Driver;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Resources\V1\Common\User\BriefUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property User $user
 */
class BriefDriverResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'user'      => new BriefUserResource($this->user),
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
