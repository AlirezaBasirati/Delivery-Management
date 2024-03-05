<?php

namespace App\Services\OrderService\Controllers\V1\Driver;

use App\Http\Controllers\Controller;
use App\Services\OrderService\Repository\V1\Common\BroadcastOrder\BroadcastOrderInterface;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BroadcastOrderController extends Controller
{
    public function __construct(
        private readonly BroadcastOrderInterface $broadcastOrderService,
    )
    {
    }

    public function pendingCount(Request $request): JsonResponse
    {
        $count = $this->broadcastOrderService->pendingCount($request->user());

        return Responser::success([
            'count' => $count
        ]);
    }
}
