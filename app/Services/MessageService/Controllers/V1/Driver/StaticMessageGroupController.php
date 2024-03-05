<?php

namespace App\Services\MessageService\Controllers\V1\Driver;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Repository\V1\Common\StaticMessageGroup\StaticMessageGroupInterface;
use App\Services\MessageService\Resources\V1\Driver\StaticMessageGroup\StaticMessageGroupResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaticMessageGroupController extends Controller
{
    public function __construct(
        private readonly StaticMessageGroupInterface $staticMessageGroupService,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $parameters = $request->all();
        $parameters['sort_by'] = 'created_at';

        $message_groups = $this->staticMessageGroupService->index($parameters);

        return Responser::collection(StaticMessageGroupResource::collection($message_groups));
    }

}
