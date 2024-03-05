<?php

namespace App\Services\FileService\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file'        => 'required',
            'description' => ['nullable','string']
        ];
    }
}
