<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    /**
     * Handle the upload of an image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $directory
     * @return string Path to the uploaded image
     */
    public function uploadImage($image, $directory)
    {
        return $image->store($directory, 'public');
    }

    /**
     * Delete an old image from storage.
     *
     * @param string|null $imagePath
     * @return void
     */
    public function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
