<?php

namespace App\Services\MessageService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Models\StaticMessageGroup;
use App\Services\MessageService\Repository\V1\Admin\StaticMessageGroup\StaticMessageGroupInterface;
use App\Services\MessageService\Requests\V1\Admin\StaticMessageGroup\StoreRequest;
use App\Services\MessageService\Requests\V1\Admin\StaticMessageGroup\UpdateRequest;
use App\Services\MessageService\Resources\V1\Common\StaticMessageGroup\StaticMessageGroupResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticMessageGroupController extends Controller
{
    public function __construct(
        private readonly StaticMessageGroupInterface $staticMessageGroupService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $static_messages = $this->staticMessageGroupService->index($request->all());

        return Responser::collection(StaticMessageGroupResource::collection($static_messages));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $static_message = $this->staticMessageGroupService->store($request->all());

        return Responser::created(new StaticMessageGroupResource($static_message->refresh()));
    }

    public function update(UpdateRequest $request, StaticMessageGroup $static_message_group): JsonResponse
    {
        $static_message_group = $this->staticMessageGroupService->update($static_message_group, $request->all());

        return Responser::success(new StaticMessageGroupResource($static_message_group));
    }

    public function show(StaticMessageGroup $static_message_group): JsonResponse
    {
        $static_message_group = $this->staticMessageGroupService->show($static_message_group);

        return Responser::success(new StaticMessageGroupResource($static_message_group));
    }

    public function destroy(StaticMessageGroup $static_message_group): JsonResponse
    {
        if ($static_message_group->reserve) {
            return Responser::error([], [__('messages.static_message_group_is_reserved')], Response::HTTP_FORBIDDEN);
        }

        $this->staticMessageGroupService->destroy($static_message_group);

        return Responser::deleted();
    }

}
