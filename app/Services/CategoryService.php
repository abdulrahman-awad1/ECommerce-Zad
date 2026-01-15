<?php

namespace App\Services;

use App\Models\Category;
use App\Services\RoomPricingService;
use App\Services\Presenters\RoomPresenter;

class CategoryService
{
    public function __construct(
        private RoomPricingService $pricingService,
        private RoomPresenter $presenter
    ) {}

    public function roomsByCategory(Category $category)
    {
        return $category->rooms()
            ->where('is_published', true)
            ->with(['images','category'])
            ->get();
    }

    public function formattedRooms(Category $category)
    {
        $rooms = $this->roomsByCategory($category);

        return $rooms->map(function ($room) {
            $pricing = $this->pricingService->format($room);
            
            return $this->presenter->present($room, $pricing);
        });
    }
}
