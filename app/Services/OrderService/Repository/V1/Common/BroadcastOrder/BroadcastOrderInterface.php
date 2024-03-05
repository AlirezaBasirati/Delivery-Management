<?php

namespace App\Services\OrderService\Repository\V1\Common\BroadcastOrder;

use App\Services\AuthenticationService\Models\User;
use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface BroadcastOrderInterface extends BaseRepositoryInterface
{
    public function storeMany(array $parameters): bool;

    public function fillAssignedAt(Order $order, array $except_drivers = []): void;

    public function selectForDriver(Driver $driver): ?Model;

    public function pendingCount(User $user): int;

    public function pendingList(Driver $driver): array;

    public function sendPendingCount(Driver $driver): void;

    public function sendPendingList(Driver $driver): void;
}
