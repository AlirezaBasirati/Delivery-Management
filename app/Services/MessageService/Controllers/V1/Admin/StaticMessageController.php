<?php

namespace App\Services\MessageService\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Models\StaticMessage;
use App\Services\MessageService\Repository\V1\Admin\StaticMessage\StaticMessageInterface;
use App\Services\MessageService\Requests\V1\Admin\StaticMessage\StoreRequest;
use App\Services\MessageService\Requests\V1\Admin\StaticMessage\UpdateRequest;
use App\Services\MessageService\Resources\V1\Common\StaticMessage\StaticMessageResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticMessageController extends Controller
{
    public function __construct(
        private readonly StaticMessageInterface $staticMessageService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $static_messages = $this->staticMessageService->index($request->all());

        return Responser::collection(StaticMessageResource::collection($static_messages));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $static_message = $this->staticMessageService->store($request->all());

        return Responser::created(new StaticMessageResource($static_message->refresh()));
    }

    public function update(UpdateRequest $request, StaticMessage $static_message): JsonResponse
    {
        $static_message = $this->staticMessageService->update($static_message, $request->all());

        return Responser::success(new StaticMessageResource($static_message));
    }

    public function show(StaticMessage $static_message): JsonResponse
    {
        $static_message = $this->staticMessageService->show($static_message);

        return Responser::success(new StaticMessageResource($static_message));
    }

    public function destroy(StaticMessage $static_message): JsonResponse
    {
        $this->staticMessageService->destroy($static_message);

        return Responser::deleted();
    }

}
