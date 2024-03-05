<?php

namespace App\Services\OrderService\Repository\V1\Common\OrderLocation;

use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use App\Services\OrderService\Libraries\ArrayOptions;
use App\Services\OrderService\Models\Order;
use App\Services\OrderService\Models\OrderLocation;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderLocationRepository extends BaseRepository implements OrderLocationInterface
{
    public function __construct(OrderLocation $model)
    {
        return parent::__construct($model);
    }

    public function storeMany(array $parameters): bool
    {
        $this->namesCompletion($parameters);
        $this->addressesCompletion($parameters);
        $this->setSort($parameters);

        DB::beginTransaction();

        foreach ($parameters as $parameter) {
            $this->model->query()->create($parameter);
        }

        DB::commit();

        return true;
    }

    /**
     * @throws ValidationException
     */
    public function addDropOffToOrder(Order $order, array $parameters): Model
    {
        if ($order->driver_id && $order->is_processing == 0) {
            throw ValidationException::withMessages(['order' => __('messages.can_not_add_drop_off')]);
        }

        $addresses = [$parameters];
        $this->namesCompletion($addresses);
        $this->addressesCompletion($addresses);

        $parameters = current($addresses);

        $lastDropOff = $this->model->query()
            ->where('type', 'drop_off')
            ->where('order_id', $order->id)
            ->max('sort');

        $parameters['sort'] = ++$lastDropOff;
        $parameters['order_id'] = $order->id;
        $parameters['type'] = 'drop_off';

        return $this->model->query()->create($parameters);
    }

    private function namesCompletion(&$locations): void
    {
        foreach ($locations as &$location) {
            if (!isset($location['name'])) {
                $location['name'] = $location['first_name'] . ' ' . $location['last_name'];
            }

            unset($location['first_name']);
            unset($location['last_name']);
        }
    }

    private function addressesCompletion(&$locations): void
    {
        foreach ($locations as &$location) {
            if (isset($location['building_number'])) {
                $location['address'] .= __('messages.building_number', ['attribute' => $location['building_number']]);
                unset($location['building_number']);
            }

            if (isset($location['unit'])) {
                $location['address'] .= __('messages.unit', ['attribute' => $location['unit']]);
                unset($location['unit']);
            }
        }
    }

    public function setSort(&$locations): void
    {
        $sorts = array_column($locations, 'sort');
        $sort = count($sorts) ? max($sorts) : 0;

        foreach ($locations as &$location) {
            if ($location['type'] == OrderLocationType::PICK_UP->value) {
                $location['sort'] = 1;
                continue;
            }

            $sort++;
            $location['sort'] = $location['sort'] ?? $sort;
        }
    }
}
