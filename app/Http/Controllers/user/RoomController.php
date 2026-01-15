<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\RoomBrowseService;
use App\Services\Presenters\RoomPresenter;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $request, RoomBrowseService $service, RoomPresenter $presenter)
    {
        // 1. جلب الغرف المفلترة
        $rooms = $service->filter($request->all());

        // 2. تحويل كل غرفة باستخدام Presenter
        $rooms = $rooms->map(fn($room) => $presenter->present($room));

        return view('user.all_rooms', [
            'rooms' => $rooms,
            'categories' => $service->categories(),
            'filters' => $request->all(),
        ]);
    }

    public function show(int $id, RoomBrowseService $service, RoomPresenter $presenter)
    {
        $room = $service->findById($id);

        // تحويل الغرفة باستخدام Presenter
        $room = $presenter->present($room);

        return view('user.show', compact('room'));
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->q;

        $rooms = Room::where('room_name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->limit(10)
            ->get()
            ->map(fn($room) => [
                'id' => $room->id,
                'name' => $room->room_name,
                'description' => $room->description,
                'price' => number_format($room->price),
                'image' => $room->images->count()
                    ? asset('images/uploads/' . $room->images->first()->image_path)
                    : null,
                'url' => route('show_room', $room->id),
            ]);

        return response()->json($rooms);
    }
}
