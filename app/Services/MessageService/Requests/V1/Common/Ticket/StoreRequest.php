<?php

namespace App\Services\MessageService\Requests\V1\Common\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id'          => ['required', 'exists:orders,id'],
            'static_message_id' => ['required', 'integer', 'exists:static_messages,id'],
            'message'           => ['required', 'string'],
            'type'              => ['required', 'string']
        ];
    }

    protected function prepareForValidation(): void
    {
        $app = \Str::before($this->route()->getName(), '.');

        $this->merge([
            'type' => $app
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
