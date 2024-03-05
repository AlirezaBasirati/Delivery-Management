<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class SyncPermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'permissions'           => ['required', 'array'],
            'permissions.*.id'      => ['integer', 'exists:permissions,id'],
            'permissions.*.is_able' => ['required', 'boolean'],
        ];
    }
}
