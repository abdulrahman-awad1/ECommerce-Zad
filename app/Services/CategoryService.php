<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Room;

class CategoryService
{
    public function roomsByCategory(Category $category): array
    {
        $rooms = $category->rooms()->where('is_published', true)
        ->with(['images','category'])
        ->get()
        ->map(function ($room) {
            $room->main_image = $this->mainImage($room);
            return $room;
        });
        $category_name = $category ? $category->name : 'قسم غير معروف';

    return [
        'category' => $category,
        'rooms' => $rooms,
        'category_name' =>$category_name
    ];
}

public function mainImage($room): string
    {
        if ($room->images && $room->images->count()) {
            return asset('images/uploads/' . $room->images->first()->image_path);
        }

        return asset('images/no-image.jpg');
    
    }
}
