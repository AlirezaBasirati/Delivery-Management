<?php

namespace App\Services\OrderService\Repository\V1\Driver\Order;

use App\Services\OrderService\Models\Order;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderInterface extends BaseRepositoryInterface
{
    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection;

    public function current(): ?Model;

    public function scheduledList(): LengthAwarePaginator|Collection;

    public function items(): ?Collection;

    public function accept(array $parameters = []): ?Model;

    public function changeStatus(array $parameters): void;

    public function select(Order $order): void;

    public function unAssign(array $parameters): void;

    public function return(array $parameters): void;

    public function storeNeedSupportLog(): void;

    public function reorderLocations(array $parameters): void;
}
