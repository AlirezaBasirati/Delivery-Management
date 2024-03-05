<?php

namespace App\Services\CustomerService\Resources\V1\Common\User;

use App\Services\AuthenticationService\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
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
        ];
    }
}
