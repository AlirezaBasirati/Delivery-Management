<?php

namespace App\Services\CustomerService\Repository\V1\Common\Customer;

use App\Services\AuthenticationService\Models\User;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserRepository;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\CustomerService\Models\Customer;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository extends BaseRepository implements CustomerInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Customer       $customer
    )
    {
        parent::__construct($this->customer);
    }

    public function conditions(Builder $query): array
    {
        return [
            'type'         => fn($value) => $query->where('type', $value),
            'created_from' => fn($value) => $query->where('created_at', '>=', $value),
            'created_to'   => fn($value) => $query->where('created_at', '<=', $value),
        ];
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $tenantId = auth()->user()->tenant?->id;

        /** @var Customer $query */
        $query->where('tenant_id', $tenantId);

        return parent::query($query, $parameters);
    }

    public function store(array $parameters): Model
    {
        $parameters['user']['role'] = Role::CUSTOMER->value;
        $parameters['user']['tenant_id'] = $parameters['customer']['tenant_id'];

        /** @var User $user */
        $user = $this->userRepository->store($parameters['user']);

        $parameters['customer']['user_id'] = $user->id;
        $parameters['customer']['verification_code'] = rand(1000, 9999);
        return parent::store($parameters['customer']);
    }

    public function update(Model $model, array $parameters): Model
    {
        /** @var Customer $model */
        $this->userRepository->update($model->user, $parameters['user']);

        return parent::update($model, $parameters['customer']);
    }

    private function getByMobileQuery(string $mobile, array $conditions = []): Builder
    {
        return $this->model->query()
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->where('mobile', $mobile)
            ->where($conditions)
            ->select('customers.*');
    }

    public function getByMobile(string $mobile, array $conditions = []): Collection|array
    {
        return $this->getByMobileQuery($mobile, $conditions)->get();
    }

    public function checkMobileExists(string $mobile, array $conditions = []): bool
    {
        return $this->getByMobileQuery($mobile, $conditions)->exists();
    }

    public function verify(Customer $customer, string $mobile): void
    {
        if (!$customer->verified_mobile) {
            $customer->verified_at = now();
            $customer->verified_mobile = $mobile;
            $customer->save();
        }
    }

    public function firstOrCreate(array $parameters): Customer
    {
        /** @var Customer $customer */
        $customer = $this->model->query()
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->where('mobile', $parameters['mobile'])
            ->where('users.tenant_id', $parameters['tenant_id'])
            ->select('customers.*')
            ->first();

        if (!$customer) {
            $parameters['username'] = $parameters['mobile'] . '-' . $parameters['tenant_id'] . '-' . Role::CUSTOMER->value;;

            /** @var Customer $customer */
            $customer = $this->store([
                'user'     => $parameters,
                'customer' => [
                    'phone'     => $parameters['mobile'],
                    'tenant_id' => $parameters['tenant_id']
                ]
            ]);
        }

        return $customer;
    }
}
