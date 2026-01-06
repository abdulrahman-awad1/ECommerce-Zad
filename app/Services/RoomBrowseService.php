<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Room;

class RoomBrowseService
{
    public function filter(array $filters)
    {
        $query = Room::where('is_published', true)
            ->with(['images','category']);

        if (!empty($filters['category'])) {
            $query->whereIn('category_id', $filters['category']);
        }

        if (isset($filters['is_featured'])) {
            $query->where('is_featured', true);
        }

        if (isset($filters['has_discount'])) {
            $query->where('discount', '>', 0);
        }

        match ($filters['sort'] ?? 'latest') {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->latest()
        };

        return $query->get();
    }

    public function categories()
    {
        return Category::all();
    }

    public function findById(int $id)
    {
    return \App\Models\Room::with(['images','category'])
        ->findOrFail($id);
    }
}
