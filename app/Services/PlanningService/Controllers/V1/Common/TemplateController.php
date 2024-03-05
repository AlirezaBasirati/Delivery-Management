<?php

namespace App\Services\PlanningService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\PlanningService\Models\Template;
use App\Services\PlanningService\Repositories\V1\Common\Template\TemplateInterface;
use App\Services\PlanningService\Requests\V1\Common\Template\StoreRequest;
use App\Services\PlanningService\Requests\V1\Common\Template\UpdateRequest;
use App\Services\PlanningService\Requests\V1\Common\Template\DeleteRequest;
use App\Services\PlanningService\Resources\V1\Common\Template\IndexTemplateResource;
use App\Services\PlanningService\Resources\V1\Common\Template\SelectTemplateResource;
use App\Services\PlanningService\Resources\V1\Common\Template\TemplateResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(
        private readonly TemplateInterface $templateService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $templates = $this->templateService->index($request->all());

        return Responser::collection(IndexTemplateResource::collection($templates));
    }

    public function select(Request $request): JsonResponse
    {
        $templates = $this->templateService->index($request->all());

        return Responser::collection(SelectTemplateResource::collection($templates));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->templateService->store($request->all());

        return Responser::success();
    }

    public function update(Template $template, UpdateRequest $request): JsonResponse
    {
        $template = $this->templateService->update($template, $request->all());

        return Responser::success(new TemplateResource($template));
    }

    public function show(Template $template): JsonResponse
    {
        $template = $this->templateService->show($template);

        return Responser::success(new TemplateResource($template));
    }

    public function destroy(Template $template, DeleteRequest $request): JsonResponse
    {
        $this->templateService->destroy($template);

        return Responser::deleted();
    }
}
