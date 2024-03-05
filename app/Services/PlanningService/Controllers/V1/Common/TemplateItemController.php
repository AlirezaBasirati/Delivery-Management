<?php

namespace App\Services\PlanningService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\PlanningService\Models\TemplateItem;
use App\Services\PlanningService\Repositories\V1\Common\TemplateItem\TemplateItemInterface;
use App\Services\PlanningService\Requests\V1\Common\TemplateItem\UpdateRequest;
use App\Services\PlanningService\Requests\V1\Common\TemplateItem\DeleteRequest;
use App\Services\PlanningService\Resources\V1\Common\TemplateItem\TemplateItemResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class TemplateItemController extends Controller
{
    public function __construct(
        private readonly TemplateItemInterface $templateItemService,
    )
    {
    }

    public function update(TemplateItem $templateItem, UpdateRequest $request): JsonResponse
    {
        $templateItem = $this->templateItemService->update($templateItem, $request->all());

        return Responser::success(new TemplateItemResource($templateItem));
    }

    public function destroy(TemplateItem $templateItem, DeleteRequest $request): JsonResponse
    {
        $this->templateItemService->destroy($templateItem);

        return Responser::deleted();
    }
}
