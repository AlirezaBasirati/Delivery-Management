<?php

namespace App\Services\FileService\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $path
 * @property mixed $size
 * @property mixed $description
 * @property mixed $extension
 */
class FileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'path'        => $this->path,
            'description' => $this->description,
            'size'        => $this->size,
            'extension'   => $this->extension,
        ];
    }
}
