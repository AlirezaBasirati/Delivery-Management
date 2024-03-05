<?php

namespace App\Services\FleetService\Resources\V1\Common\User;

use App\Services\AuthorizationService\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $national_code
 * @property string $mobile
 * @property integer $status
 * @property Role $role
 */
class BriefUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id"         => $this->id,
            "username"   => $this->username,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'mobile'     => $this->mobile,
            'national_code'     => $this->national_code,
            "status"     => $this->status
        ];
    }
}
