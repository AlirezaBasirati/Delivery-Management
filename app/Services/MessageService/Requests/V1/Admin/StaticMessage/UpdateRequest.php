<?php

namespace App\Services\MessageService\Requests\V1\Admin\StaticMessage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['exists:static_message_groups,id'],
            'title'    => ['string'],
            'message'  => ['string'],
        ];
    }
}
