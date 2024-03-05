<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DestroyRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $role = $this->route('role');

                if ($role->permissions()->count() || $role->users()->count()) {
                    $validator->errors()->add('role', __('messages.can_not_delete_role'));
                }
            }
        ];
    }
}
