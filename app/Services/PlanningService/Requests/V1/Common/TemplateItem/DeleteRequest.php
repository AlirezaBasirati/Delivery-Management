<?php

namespace App\Services\PlanningService\Requests\V1\Common\TemplateItem;

use App\Services\PlanningService\Models\TemplateItem;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var TemplateItem $templateItem */
        $templateItem = $this->route('templateItem');

        return $this->user()->tenant_id == $templateItem->template->tenant_id;
    }

    public function rules(): array
    {
        return [];
    }
}
