<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class SyncRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
