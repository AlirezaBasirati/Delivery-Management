<?php

namespace App\Services\CustomerService\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Services\CustomerService\Models\Bookmark;
use App\Services\CustomerService\Repository\V1\Customer\Bookmark\BookmarkInterface;
use App\Services\CustomerService\Requests\V1\Customer\Bookmark\StoreRequest;
use App\Services\CustomerService\Requests\V1\Customer\Bookmark\UpdateRequest;
use App\Services\CustomerService\Resources\V1\Customer\Bookmark\BookmarkResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct(private readonly BookmarkInterface $repository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $bookmarks = $this->repository->index($request->all());

        return Responser::collection(BookmarkResource::collection($bookmarks));
    }

    public function store(StoreRequest $Request): JsonResponse
    {
        $this->repository->store($Request->validated());

        return Responser::success();
    }

    public function update(Bookmark $bookmark, UpdateRequest $request): JsonResponse
    {
        $bookmark = $this->repository->update($bookmark, $request->validated());

        return Responser::success(new BookmarkResource($bookmark));
    }

    public function show(Bookmark $bookmark): JsonResponse
    {
        $bookmark = $this->repository->show($bookmark);

        return Responser::info(new BookmarkResource($bookmark));
    }

    public function destroy(Bookmark $bookmark): JsonResponse
    {
        $this->repository->destroy($bookmark);

        return Responser::deleted();
    }
}
