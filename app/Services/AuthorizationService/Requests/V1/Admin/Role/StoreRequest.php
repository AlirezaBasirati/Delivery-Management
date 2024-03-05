<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                 => ['required', 'string', 'max:193', 'unique:roles,name'],
            'title'                => ['required', 'string', 'max:193', 'unique:roles,title'],
            'status'               => ['required', 'boolean'],
            'permissions'          => ['nullable', 'array'],
            'permissions.all'      => ['nullable', 'boolean'],
            'permissions.only'     => ['nullable', 'array'],
            'permissions.only.*'   => ['integer', 'exists:permissions,id'],
            'permissions.except'   => ['nullable', 'array'],
            'permissions.except.*' => ['integer', 'exists:permissions,id'],
            'permissions.append'   => ['nullable', 'array'],
            'permissions.append.*' => ['integer', 'exists:permissions,id']
        ];
    }
}
