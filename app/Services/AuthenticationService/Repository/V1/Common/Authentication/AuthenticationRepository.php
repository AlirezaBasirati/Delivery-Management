<?php

namespace App\Services\AuthenticationService\Repository\V1\Common\Authentication;

use App\Services\AuthenticationService\Enumerations\V1\AppType;
use App\Services\AuthenticationService\Helper\V1\Helper;
use App\Services\AuthenticationService\Models\User;
use App\Services\AuthenticationService\Repository\V1\Common\Temporary\TemporaryRepositoryInterface;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use App\Services\CustomerService\Models\Customer;
use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerInterface;
use App\Services\FleetService\Enumerations\V1\DriverStatus;
use App\Services\FleetService\Models\Driver;
use App\Services\FleetService\Repository\V1\Common\Driver\DriverInterface;
use App\Services\TenantService\Models\Tenant;
use App\Services\TenantService\Repository\V1\Common\Tenant\TenantInterface;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthenticationRepository extends BaseRepository implements AuthenticationRepositoryInterface
{
    public function __construct(
        protected User                         $user,
        protected TemporaryRepositoryInterface $temporaryRepository,
        private readonly DriverInterface       $driverService,
        private readonly CustomerInterface     $customerService,
        private readonly TenantInterface       $tenantService
    )
    {
        parent::__construct($this->user);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function login(array $parameters): array
    {
        $user = $this->checkUser($parameters['username']);

        $auth = $this->retrieveToken($parameters);

        return compact('user', 'auth');
    }

    public function logout(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        return $user->token()->delete();
    }

    public function me(): User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

    /**
     * @param array $parameters
     * @return bool
     * @throws ValidationException
     */
    public function changePassword(array $parameters): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (trim($parameters['password']) == '') {
            throw ValidationException::withMessages([
                'password' => [__('authentication::authentication.password-week')]
            ]);
        }

        $user->status = User::STATUS_ACTIVE;
        $user->password = $parameters['password'];

        return $user->save();
    }

    /**
     * @param string $username
     * @return User
     * @throws ValidationException
     * @throws AuthorizationException
     */
    private function checkUser(string &$username): User
    {
        /** @var User $user */
        $user = $this->model->query()
            ->where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('mobile', $username)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => [__('authentication::authentication.incorrect')]
            ]);
        }

        if (!$user->hasRoles('admin', 'dispatcher', 'tenant')) {
            throw new AuthorizationException();
        }

        $username = $user->username;

        return $user;
    }

    /**
     * @param array $parameters
     * @return array
     * @throws ValidationException
     */
    private function retrieveToken(array $parameters): array
    {
        $data = [
            'client_id'     => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'grant_type'    => 'password',
            'username'      => $parameters['username'],
            'password'      => $parameters['password'],
            'scope'         => '*'
        ];

        return Http::asForm()
            ->baseUrl(env('PASSPORT_BASE_URL'))
            ->post('/oauth/token', $data)
            ->onError(fn() => throw ValidationException::withMessages([
                'password' => [__('authentication::authentication.password')]
            ]))
            ->json();
    }

    public function refresh(array $parameters): array
    {
        $data = [
            'client_id'     => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'grant_type'    => 'refresh_token',
            'refresh_token' => $parameters['refresh_token'],
            'scope'         => '*'
        ];


        return Http::asForm()
            ->baseUrl(env('PASSPORT_BASE_URL'))
            ->post('/oauth/token', $data)
            ->onError(fn() => throw ValidationException::withMessages([
                'refresh_token' => [__('authentication::authentication.token')]
            ]))
            ->json();
    }


    /**
     * @param array $parameters
     * @return array
     * @throws ValidationException
     */
    public function check(array $parameters): array
    {
        $username = $parameters['username'];
        $otp = $parameters['otp'] ?? false;

        $column = $this->getTypeUsername($username);

        $user = $this->getUser($username, $column, $parameters);

        if (!$user) {
            $this->temporaryRepository->sendOTP($column, $username);

            return [
                'exist'        => false,
                'has_password' => false
            ];
        }

        if ($user->password && !$otp) {
            return [
                'exist'        => true,
                'has_password' => true
            ];
        } else {
            $this->temporaryRepository->sendOTP($column, $username);

            return [
                'exist'        => true,
                'has_password' => false
            ];
        }
    }

    private function getUser($username, $column, array &$parameters)
    {
        if (in_array($parameters['app'], [AppType::CUSTOMER->value, AppType::DRIVER->value])) {
            $parameters['tenant_id'] = $this->tenantService->findByKey($parameters['key'])?->id;

            if (!$parameters['tenant_id']) {
                throw ValidationException::withMessages(['key' => __('messages.invalid_url')]);
            }

            $role = Role::fromName(strtoupper($parameters['app']))->value;

            /** @var User $user */
            $user = $this->user->query()->where($column, $username)->where('role_id', $role)->where('tenant_id', $parameters['tenant_id'])->first();

        } else {
            /** @var User $user */
            $user = $this->user->query()
                ->where($column, $username)
                ->first();
        }

        return $user;
    }

    /**
     * @param array $parameters
     * @return array
     * @throws ValidationException|AuthorizationException
     */
    public function verify(array $parameters): array
    {
        $username = $parameters['username'];

        $column = $this->getTypeUsername($username);

        $user = $this->getUser($username, $column, $parameters);

        if (array_key_exists('code', $parameters)) {
            $this->temporaryRepository->check($column, $username, $parameters['code']);

            if (!$user) {
                if ($parameters['app'] == AppType::DRIVER->value) {
                    $data = [
                        $column     => $username . '-' . $parameters['tenant_id'] . '-' . Role::DRIVER->value,
                        'status'    => DriverStatus::Inactive->value,
                        'username'  => $username,
                        'tenant_id' => $parameters['tenant_id']
                    ];

                    if ($column == 'mobile') {
                        $data['emergency_mobile'] = $username;
                    }

                    /** @var Driver $driver */
                    $driver = $this->driverService->store($data);

                    $user = $driver->user;
                } elseif ($parameters['app'] == AppType::CUSTOMER->value) {
                    /** @var Customer $customer */
                    $customer = $this->customerService->store([
                        'user'     => [
                            $column    => $username,
                            'status'   => DriverStatus::Inactive->value,
                            'username' => $username . '-' . $parameters['tenant_id'] . '-' . Role::CUSTOMER->value
                        ],
                        'customer' => $column == 'mobile' ? [
                            'tenant_id'       => $parameters['tenant_id'],
                            'phone'           => $username,
                            'verified_mobile' => $username,
                            'verified_at'     => now()
                        ] : []
                    ]);

                    $user = $customer->user;
                } else {
                    throw ValidationException::withMessages([
                        'app' => [__('validation.required')]
                    ]);
                }

            } elseif (!$user->hasRoles('driver', 'customer')) {
                throw new AuthorizationException();
            }
        } else {
            if (!Hash::check($parameters['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'password' => [__('authentication::authentication.password')]
                ]);
            }
        }

        $auth['token'] = $user->createToken('app')->accessToken;

        return compact('auth', 'user');
    }

    /**
     * @param array $parameters
     * @return void
     * @throws ValidationException
     */
    public function forget(array $parameters): void
    {
        $username = $parameters['username'];

        $column = $this->getTypeUsername($username);

        $user = $this->getUser($username, $column, $parameters);

        if (!$user) {
            throw ValidationException::withMessages(['username' => __('validation.exists', ['attribute' => __('validation.attributes.username')])]);
        }

        $this->temporaryRepository->sendOTP($column, $username);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ValidationException
     */
    public function reset(array $parameters): string
    {
        $username = $parameters['username'];

        $column = $this->getTypeUsername($username);

        $this->temporaryRepository->check($column, $username, $parameters['code']);

        return encrypt($username);
    }

    /**
     * @param mixed $username
     * @return string
     * @throws ValidationException
     */
    public function getTypeUsername(string &$username): string
    {
        if (Helper::isMobile($username)) {
            $username = Helper::standardMobile($username);
            $column = 'mobile';
        } elseif (Helper::isEmail($username)) {
            $column = 'email';
        } else {
            throw ValidationException::withMessages([
                'username' => __('validation.exists',
                    ['attribute' => __('validation.attributes.username')]
                )
            ]);
        }
        return $column;
    }

    /**
     * @param array $parameters
     * @return array
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function setPassword(array $parameters): array
    {
        $username = decrypt($parameters['code']);

        $column = $this->getTypeUsername($username);

        $user = $this->getUser($username, $column, $parameters);

        if (!$user) {
            throw ValidationException::withMessages(['username' => __('validation.exists', ['attribute' => __('validation.attributes.password')])]);
        }

        if (!$user->hasRoles('driver', 'customer')) {
            throw new AuthorizationException();
        }

        $user->status = true;
        $user->password = $parameters['password'];
        $user->save();
        $auth['token'] = $user->createToken('app')->accessToken;

        return compact('auth', 'user');
    }

    public function update(Model $model, array $parameters): Model
    {
        DB::beginTransaction();

        $parameters['status'] = true;

        /** @var User $model */
        $result = parent::update($model, $parameters);

        if ($model->hasRoles('driver') && isset($parameters['emergency_mobile'])) {
            $this->driverService->update($model->driver, ['emergency_mobile' => $parameters['emergency_mobile']]);
        } elseif ($model->hasRoles('customer')) {
            $this->customerService->verify($model->customer, $model->mobile);
        }

        DB::commit();

        return $result;
    }
}
