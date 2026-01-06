<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomFilterRequest;
use App\Services\RoomBrowseService;
use App\Services\RoomPricingService;
use App\Services\CategoryService;
use App\Services\RoomService;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Category;



class RoomController extends Controller
{
    public function index(
        Request $request,
        RoomBrowseService $filterService, // الـ Service الجديدة
        CategoryService $imageService,
        RoomPricingService $pricingService
    ) {
        // 1. استخدام الـ Service لجلب الغرف المفلترة
        $rooms = $filterService->filter($request->all());
    
        // 2. معالجة الصور والأسعار (Mapping)
        $rooms->map(function ($room) use ($imageService, $pricingService) {
            $pricing = $pricingService->format($room);
            
            $room->image_url = $imageService->mainImage($room);
            $room->is_discounted = $pricing['is_discounted'];
            $room->formatted_price = $pricing['price'];
            $room->old_price = $pricing['old_price'];
            $room->discount_percent = $pricing['discount_percent'];
    
            return $room;
        });
    
        return view('user.all_rooms', [
            'rooms' => $rooms,
            'categories' => $filterService->categories(), // جلب الأقسام من السيرفس أيضاً
            'filters' => $request->all(),
        ]);
    }
    

    public function show(int $id, RoomBrowseService $service, RoomPricingService $pricingService, CategoryService $imageService)
{
    $room = $service->findById($id);

    // معالجة الصور والسعر والخصم
    $pricing = $pricingService->format($room);
    $room->image_url = $imageService->mainImage($room);
    $room->formatted_price = $pricing['price'];
    $room->old_price = $pricing['old_price'];
    $room->is_discounted = $pricing['is_discounted'];
    $room->discount_percent = $pricing['discount_percent'];

    return view('user.show', compact('room'));
}

    
    public function ajaxSearch(Request $request)
    {
        $q = $request->q;
    
        $rooms = Room::where('room_name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->limit(10)
            ->get()
            ->map(function ($room) {

                $image = null;
    
                if ($room->images->count()) {
                    $path = $room->images->first()->image_path;
                    $image = asset('images/uploads/' . $path);
                }
    
                return [
                    'id'    => $room->id,
                    'name'  => $room->room_name,
                    'description' =>$room->description,
                    'price' => number_format($room->price),
                    'image' => $image,
                    'url'   => route('show_room', $room->id),
                ];
            });
    
        return response()->json($rooms);
    }
    


    
}
