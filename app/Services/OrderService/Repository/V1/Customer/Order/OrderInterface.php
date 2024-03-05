<?php

namespace App\Services\OrderService\Repository\V1\Customer\Order;

use App\Services\NotificationService\Enumerations\V1\NotificationType;
use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderInterface extends BaseRepositoryInterface
{
    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection;

    public function currents(): array|\Illuminate\Database\Eloquent\Collection;

    public function orderInfoNotification(Order $order, NotificationType $type): void;

    public function hurry(Order $order): void;
}
