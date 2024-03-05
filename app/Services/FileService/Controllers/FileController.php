<?php

namespace App\Services\FileService\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FileService\Repository\FileServiceInterface as FileServiceRepository;
use App\Services\FileService\Requests\StoreFileRequest;
use App\Services\FileService\Resources\FileResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{

    public function __construct(private readonly FileServiceRepository $fileRepository)
    {
    }

    public function store(StoreFileRequest $request): JsonResponse
    {
        $file = $this->fileRepository->store($request);

        return Responser::created(new FileResource($file));
    }
}
