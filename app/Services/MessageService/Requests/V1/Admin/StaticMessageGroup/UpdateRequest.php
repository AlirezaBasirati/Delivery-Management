<?php

namespace App\Services\MessageService\Requests\V1\Admin\StaticMessageGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['exists:static_message_groups,id'],
            'title'     => ['string'],
            'name'      => ['string'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->route('static_message_group')->reserve && isset($this->name)) {
                    $validator->errors()->add('name', __('messages.static_message_group_is_reserved'));
                }
            }
        ];
    }
}
