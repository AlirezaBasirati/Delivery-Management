<?php

namespace App\Services\AuthenticationService\Resources\V1\Common\User;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthenticationService\Resources\V1\Common\Customer\BriefCustomerResource;
use App\Services\AuthenticationService\Resources\V1\Common\Tenant\BriefTenantResource;
use App\Services\FleetService\Resources\V1\Common\Driver\BriefDriverResource;
use Illuminate\Http\Resources\Json\JsonResource;


/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $parameters = [
            'id'            => $this->id,
            'username'      => $this->username,
            'email'         => $this->email,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'national_code' => $this->national_code,
            'mobile'        => $this->mobile,
            'is_blocked'    => $this->is_blocked,
            'status'        => $this->status,
            'birth_date'    => $this->birth_date,
        ];

        if ($this->hasRoles('driver')) {
            $parameters['driver'] = new BriefDriverResource($this->driver);
        }

        if ($this->hasRoles('customer')) {
            $parameters['customer'] = new BriefCustomerResource($this->customer);
        }

        if ($this->hasRoles('tenant')) {
            $parameters['tenant'] = new BriefTenantResource($this->tenant);
        }

        return $parameters;
    }
}
