<?php
namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    public function storeMany(array $files, int $roomId)
    {
        foreach ($files as $file) {
            $this->store($file, $roomId);
        }
    }

    public function store(UploadedFile $file, int $roomId)
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/uploads'), $fileName);

        \App\Models\Image::create([
            'room_id'    => $roomId,
            'image_path' => $fileName,
        ]);
    }

    public function delete($image)
    {
        $path = public_path('images/uploads/' . $image->image_path);
        if (file_exists($path)) {
            unlink($path);
        }
        $image->delete();
    }
}