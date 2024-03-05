<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $role = $this->route('role');

        return [
            'name'                 => ['string', 'max:193', 'unique:roles,name,' . $role->id],
            'title'                => ['string', 'max:193', 'unique:roles,title,' . $role->id],
            'status'               => ['boolean'],
            'permissions'          => ['array'],
            'permissions.all'      => ['boolean'],
            'permissions.only'     => ['array'],
            'permissions.only.*'   => ['integer', 'exists:permissions,id'],
            'permissions.except'   => ['array'],
            'permissions.except.*' => ['integer', 'exists:permissions,id'],
            'permissions.append'   => ['array'],
            'permissions.append.*' => ['integer', 'exists:permissions,id']
        ];
    }
}
