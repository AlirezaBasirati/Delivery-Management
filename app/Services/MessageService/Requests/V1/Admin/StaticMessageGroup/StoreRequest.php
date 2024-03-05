<?php

namespace App\Services\MessageService\Requests\V1\Admin\StaticMessageGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['exists:static_message_groups,id'],
            'title'     => ['required', 'string'],
            'name'      => ['required', 'string'],
        ];
    }
}
