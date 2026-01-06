<?php
namespace App\Services;

use App\Queries\RoomQuery;
use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Room;



class RoomPricingService
{
    public function format($room)
{
    $isDiscounted = $room->discount > 0;

    return [
        'is_discounted' => $isDiscounted,

        // السعر الأساسي من الداتابيز
        'price' => number_format($room->price),

        // السعر القديم يظهر فقط لو فيه خصم
        'old_price' => $isDiscounted
            ? number_format($room->price + $room->discount)
            : null,

        'discount_percent' => $isDiscounted
            ? round(($room->discount / ($room->price + $room->discount)) * 100)
            : null,
    ];
}

    

}