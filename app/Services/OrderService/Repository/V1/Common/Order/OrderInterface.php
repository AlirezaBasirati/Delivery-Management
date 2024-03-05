<?php

namespace App\Services\OrderService\Repository\V1\Common\Order;

use App\Services\FleetService\Models\Driver;
use App\Services\OrderService\Enumerations\V1\OrderStatus;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OrderInterface extends BaseRepositoryInterface
{
    public function store(array $parameters): Model;

    public function cancel(Order $order, int $status_id = null): Order;

    public function assignDriver(Order $order, Driver $driver, array $parameters): Order;

    public function unAssignDriver(Order $order, array $parameters): Order;

    public function broadcast(Order $order, array $parameters): Order;

    public function count(): Collection;

    public function unAssignStatus(Order $order): OrderStatus;

    public function bulkAssignDriver(array $parameters): void;

    public function bulkDispatch(array $parameters): void;
}
