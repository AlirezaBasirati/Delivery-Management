<?php

namespace App\Services\AuthenticationService\Resources\V1\Common\User;

use App\Services\AuthorizationService\Models\Role;
use App\Services\AuthorizationService\Resources\V1\Admin\Role\BriefRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;


/**
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $national_code
 * @property string $mobile
 * @property string $birth_date
 * @property integer $status
 * @property Role $role
 */
class BriefUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'email'         => $this->email,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'national_code' => $this->national_code,
            'mobile'        => $this->mobile,
            'status'        => $this->status,
            'birth_date'    => $this->birth_date,
            'role'          => new BriefRoleResource($this->role)
        ];
    }
}
