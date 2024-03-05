<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'    => ['required'],
            'title'   => ['required', 'string', 'max:193'],
            'routes'  => ['prohibited'],
            'roles'   => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ];
    }
}
