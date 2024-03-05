<?php

namespace App\Services\OrderService\Resources\V1\Common\User;

use App\Services\AuthorizationService\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;


/**
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $national_code
 * @property string $mobile
 * @property integer $status
 * @property Collection<Role> $roles
 */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'national_code' => $this->national_code,
            'mobile'        => $this->mobile
        ];
    }
}
