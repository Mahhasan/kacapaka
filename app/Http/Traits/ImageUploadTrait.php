<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, string $inputName, string $folder): ?string
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/' . $folder . '/';
            $file->move(public_path($path), $fileName);
            return $path . $fileName;
        }
        return null;
    }

    public function updateImage(Request $request, string $inputName, string $folder, ?string $oldPath): ?string
    {
        if ($request->hasFile($inputName)) {
            $this->deleteImage($oldPath);
            return $this->uploadImage($request, $inputName, $folder);
        }
        return $oldPath;
    }

    public function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
