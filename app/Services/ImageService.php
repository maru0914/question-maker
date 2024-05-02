<?php

namespace App\Services;

use App\Exceptions\StorageException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @throws StorageException
     */
    public function upload(UploadedFile $file): string
    {
        $filePath = Storage::disk('public')->putFile('images', $file);
        if (! $filePath) {
            throw new StorageException('Image upload failed');
        }

        return $filePath;
    }

    /**
     * @throws StorageException
     */
    public function delete(string $path): void
    {
        $result = Storage::disk('public')->delete($path);

        if (! $result) {
            throw new StorageException('Image delete failed');
        }

    }
}
