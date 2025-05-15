<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait FileUpload
{
    public function uploadFile(UploadedFile $file, string $directory = 'uploads', ?string $oldFilePath = null): string
    {
        // Delete the old file if provided
        if ($oldFilePath) {
            $this->deleteFile($oldFilePath);
        }

        // Generate new file name correctly
        $filename = 'educode_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $fullPath = $directory . '/' . $filename;

        // Move the new file
        $file->move(public_path($directory), $filename);

        return '/' . $fullPath;
    }

    public function deleteFile(?string $filePath): void
    {
        if ($filePath && File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
    }
}
