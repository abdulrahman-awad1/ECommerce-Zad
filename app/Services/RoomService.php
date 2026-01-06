<?php
namespace App\Services;

use App\Queries\RoomQuery;
use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Room;



class RoomService
{
    public function __construct(private RoomQuery $query) {}

    public function homeData(): array
    {
        $rooms = $this->query
            ->withRelations($this->query->published())
            ->latest()
            ->get();

        return [
            'latestRooms'   => $this->present($rooms->take(4)),
            'featuredRooms' => $this->present( $rooms->where('is_featured', true)->take(4)),
            'categories'    => Category::all(),
        ];
    }

    private function present(Collection $rooms): Collection
    {
        return $rooms->map(function ($room) {
            $room->main_image = $this->mainImage($room);
            $room->price_text = number_format($room->price) . ' ج.م';
            return $room;
        });
    }

    public function mainImage($room): string
    {
        $image = $room->images->first();

        if (!$image) {
            return asset('images/no-image.jpg');
        }

        return asset('storage/'.$image->image_path);
    }

    public function create(array $data): Room
    {
        return Room::create([
            'room_name' => $data['room_name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'] ?? null,
            'sku' => $data['sku'] ?? null,
            'price' => $data['price'],
            'discount' => $data['discount'] ?? 0,
            'is_published' => isset($data['is_published']),
            'is_featured' => isset($data['is_featured']),
        ]);
    }

    public function update(Room $room, array $data): void
    {
        $room->update([
            'room_name' => $data['room_name'],
            'category_id' => $data['category_id'],
            'description' => $data['description'] ?? null,
            'sku' => $data['sku'] ?? null,
            'price' => $data['price'],
            'discount' => $data['discount'] ?? 0,
            'is_published' => (bool) ($data['is_published'] ?? false),
            'is_featured'  => (bool) ($data['is_featured'] ?? false),
        ]);
    }

    public function delete(Room $room): void
    {
        foreach ($room->images as $image) {
            $image->delete();
        }

        $room->delete();
    }
}


