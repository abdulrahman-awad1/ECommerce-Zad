<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\RoomPricingService;


class CategoryController extends Controller
{

public function show(
    Category $category,
    CategoryService $categoryService,
    RoomPricingService $pricingService
) {
    $data = $categoryService->roomsByCategory($category);

    $rooms = collect($data['rooms'])->map(function ($room) use ($pricingService, $categoryService) {

        $pricing = $pricingService->format($room);

        $room->image_url = $categoryService->mainImage($room);
        $room->formatted_price = $pricing['price'];
        $room->old_price = $pricing['old_price'];
        $room->is_discounted = $pricing['is_discounted'];
        $room->discount_percent = $pricing['discount_percent'];

        return $room;
    });

    return view('user.category', [
        'rooms' => $rooms,
        'category_name' => $category->name,
    ]);
}

}
