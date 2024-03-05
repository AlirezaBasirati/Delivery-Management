<?php

namespace App\Services\FileService\Repository;

use App\Services\FileService\Models\File;
use Illuminate\Http\Request;

interface FileServiceInterface
{
    public function store(Request $request): File;
}
