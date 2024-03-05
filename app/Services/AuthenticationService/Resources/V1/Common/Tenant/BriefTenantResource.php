<?php

namespace App\Services\AuthenticationService\Resources\V1\Common\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $name
 * @property string $webhook_url
 */
class BriefTenantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'webhook_url' => $this->webhook_url,
        ];
    }
}
