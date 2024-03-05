<?php

namespace App\Services\OrderService\Resources\V1\Common\OrderStatus;

use App\Services\OrderService\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property Collection<Order> $orders
 */
class OrdersCountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'name'         => $this->name,
            'orders_count' => $this->orders()
                ->where('tenant_id', auth()->user()->tenant_id)
                ->when($request->created_from ?? null, function ($query, $created_from) {
                    $query->where('created_at', '>', $created_from);
                }, function ($query) {
                    $query->where('created_at', '>', Carbon::today());
                })->count()
        ];
    }
}
