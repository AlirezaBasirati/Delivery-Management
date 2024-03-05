<?php

namespace App\Services\FileService\Repository;

use App\Services\FileService\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileServiceRepository implements FileServiceInterface
{
    public function __construct(private readonly File $file)
    {
    }

    public function store(Request $request): File
    {
        $id = Str::uuid();
        $extension = $request->file('file')->extension();
        $size = $request->file('file')->getSize();
        $now = now()->format('Y/m/d');
        $path = sprintf("%s/%s/", env('ROOT_PATH'), $now);
        $fileName = sprintf("%s.%s", $id, $extension);

        /** @var File $file */
        $file = $this->file->query()->create([
            'id'          => $id,
            'path'        => $path . $fileName,
            'description' => $request->description ?? null,
            'size'        => $size,
            'extension'   => $extension,
        ]);

        Storage::putFileAs($path, $request->file('file'), $fileName);

        return $file;
    }
}
