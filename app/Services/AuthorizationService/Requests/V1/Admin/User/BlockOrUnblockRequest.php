<?php

namespace App\Services\AuthorizationService\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class BlockOrUnblockRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_blocked' => ['required', 'boolean'],
        ];
    }
}
