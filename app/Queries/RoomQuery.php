<?php
namespace App\Queries;

use App\Models\Room;

class RoomQuery
{
    public function published()
    {
        return Room::where('is_published', true);
    }

    public function withRelations($query)
    {
        return $query->with(['images','category']);
    }
}
