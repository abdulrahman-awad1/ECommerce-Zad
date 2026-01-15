<?php

namespace App\Services\Presenters;
use App\Services\RoomPricingService;


class RoomPresenter
{
    private RoomPricingService $pricingService;

    public function __construct(RoomPricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }
    
    public function present($room): object
    {
        $pricing = $this->pricingService->format($room);
        return (object) [
            'id' => $room->id,
            'room_name' => $room->room_name,
            'description' => $room->description,
            'is_featured' => $room->is_featured,
            'images' => $room->images, 
            'image_url' => $this->mainImage($room),
            'formatted_price' => $pricing['price'],
            'old_price' => $pricing['old_price'],
            'is_discounted' => $pricing['is_discounted'],
            'discount_percent' => $pricing['discount_percent'],
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
