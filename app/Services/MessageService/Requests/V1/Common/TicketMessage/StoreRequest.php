<?php

namespace App\Services\MessageService\Requests\V1\Common\TicketMessage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'integer', 'exists:tickets,id'],
            'message'   => ['required'],
            'type'      => ['required', 'string']
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
