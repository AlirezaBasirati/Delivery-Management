<?php

namespace App\Services\CustomerService\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use App\Services\CustomerService\Exports\V1\CustomersExport;
use App\Services\CustomerService\Models\Customer;
use App\Services\CustomerService\Repository\V1\Common\Customer\CustomerInterface;
use App\Services\CustomerService\Requests\V1\Common\Customer\CustomerStoreRequest;
use App\Services\CustomerService\Requests\V1\Common\Customer\IndexRequest;
use App\Services\CustomerService\Requests\V1\Common\Customer\UserStoreRequest;
use App\Services\CustomerService\Resources\V1\Common\Customer\CustomerResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerInterface $repository)
    {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $customers = $this->repository->index($request->all());

        return Responser::collection(CustomerResource::collection($customers));
    }

    public function store(UserStoreRequest $userStoreRequest, CustomerStoreRequest $customerStoreRequest): JsonResponse
    {
        $parameters = [
            'user'     => $userStoreRequest->validated(),
            'customer' => $customerStoreRequest->validated()
        ];

        $this->repository->store($parameters);

        return Responser::success();
    }

    public function show(Customer $customer): JsonResponse
    {
        $customer = $this->repository->show($customer);

        return Responser::info(new CustomerResource($customer));
    }

    public function export(IndexRequest $request): BinaryFileResponse
    {
        $parameters = $request->all();
        $parameters['paginate'] = false;

        $customers = $this->repository->index($parameters);

        return Excel::download(new CustomersExport($customers), 'customer_export', \Maatwebsite\Excel\Excel::CSV);
    }
}
