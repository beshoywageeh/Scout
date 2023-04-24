<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function uploadImage($folder, $image, $name)
    {
        $extension = strtolower($image->extension());
        $filename = $name.'.'.$extension;
        $image->getClientOriginalName = $filename;
        $image->storeAs($folder, $filename, 'upload_attachments');

        return $filename;
    }

    public function deleteImage($disk, $path)
    {
        Storage::disk($disk)->delete($path);
    }
}
