<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    /**
     * Handle Image Upload.
     * Path: public/uploads/{module_name}/
     */
    public function uploadImage(Request $request, string $inputName, string $folder): ?string
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/' . $folder, $fileName, 'public');
            return $path;
        }
        return null;
    }

    /**
     * Handle Image Update.
     */
    public function updateImage(Request $request, string $inputName, string $folder, ?string $oldPath): ?string
    {
        if ($request->hasFile($inputName)) {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            return $this->uploadImage($request, $inputName, $folder);
        }
        return $oldPath;
    }

    /**
     * Handle Image Deletion.
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
