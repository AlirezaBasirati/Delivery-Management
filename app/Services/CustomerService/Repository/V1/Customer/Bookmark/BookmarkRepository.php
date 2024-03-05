<?php

namespace App\Services\CustomerService\Repository\V1\Customer\Bookmark;

use App\Services\CustomerService\Models\Bookmark;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BookmarkRepository extends BaseRepository implements BookmarkInterface
{
    public function __construct(
        private readonly Bookmark $bookmark
    )
    {
        parent::__construct($this->bookmark);
    }

    public function conditions(Builder $query): array
    {
        return [
            'customer_id' => '='
        ];
    }

    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection
    {
        $parameters['customer_id'] = Auth::user()->customer?->id;

        return parent::index($parameters);
    }

    public function store(array $parameters): Model
    {
        return Bookmark::query()->create([
            'customer_id' => Auth::user()->customer?->id,
            'name'        => $parameters['name'],
            'address'     => $parameters['address'],
            'latitude'    => $parameters['latitude'],
            'longitude'   => $parameters['longitude'],
        ]);
    }
}
