<?php

namespace App\Services\MessageService\Requests\V1\Admin\StaticMessage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'exists:static_message_groups,id'],
            'title'    => ['required', 'string'],
            'message'  => ['required', 'string'],
        ];
    }
}
