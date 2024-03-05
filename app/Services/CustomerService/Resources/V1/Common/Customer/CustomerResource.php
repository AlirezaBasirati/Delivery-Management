<?php

namespace App\Services\CustomerService\Resources\V1\Common\Customer;

use App\Services\CustomerService\Models\Customer;
use App\Services\CustomerService\Resources\V1\Common\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'balance'           => $this->balance,
            'verified_mobile'   => $this->verified_mobile,
            'verification_code' => $this->verification_code,
            'verified_at'       => $this->verified_at,
            'type'              => $this->type,
            'phone'             => $this->phone,
            'address'           => $this->address,
            'user'              => new UserResource($this->user),
            'created_at'        => $this->created_at,
        ];
    }
}
