<?php

namespace App\Services\AuthenticationService\Resources\V1\Common\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $type
 * @property integer $balance
 */
class BriefCustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'type'    => $this->type,
            'balance' => $this->balance,
        ];
    }
}
