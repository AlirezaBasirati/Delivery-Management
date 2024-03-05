<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
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

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $permission = $this->route('permission');

                if (isset($permission['route'])) {
                    $validator->errors()->add('name', __('messages.can_not_update_permission_name'));
                }
            }
        ];
    }
}
