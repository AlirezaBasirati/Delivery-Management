<?php

namespace App\Services\MessageService\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Services\MessageService\Repository\V1\Common\StaticMessage\StaticMessageInterface;
use App\Services\MessageService\Resources\V1\Customer\StaticMessage\StaticMessageResource;
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
        $messages = $this->staticMessageService->index($request->all());

        return Responser::collection(StaticMessageResource::collection($messages));
    }

}
