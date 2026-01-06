<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Image;
use App\Models\Room;
use App\Services\RoomService;
use App\Services\ImageService;


class RoomController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'rooms' => Room::with('images')->get()
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(
        StoreRoomRequest $request,
        RoomService $roomService,
        ImageService $imageService
        ) {

            $room = $roomService->create($request->validated());
            $imageService->storeMany(
            $request->file('images'),
            $room->id
            );
            return redirect()->route('create')->with('success', 'تم إنشاء الغرفة بنجاح');
                 

    }
    public function show(Room $room)
    {
        $room->load(['images', 'category']);

        return view('admin.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.edit', compact('room'));
    }

    public function update(
        UpdateRoomRequest $request,
        Room $room,
        RoomService $roomService,
        ImageService $imageService
    ) {
        // جمع البيانات من الريكويست
        $data = $request->validated();
    
        // معالجة الـ checkboxes
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
    
        // تحديث بيانات الغرفة
        

        $roomService->update($room, $data);
    
        // حذف الصور المختارة
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = $room->images()->find($imageId);
                if ($image) {
                    $imageService->delete($image);
                }
            }
        }
    
        // إضافة صور جديدة
        if ($request->hasFile('images')) {
            $imageService->storeMany(
                $request->file('images'),
                $room->id
            );
        }
    
        return back()->with('success', 'تم تعديل الغرفة بنجاح');
    }
    

    public function destroy(Room $room, RoomService $service)
    {
        $service->delete($room);

        return redirect()->route('rooms.index')->with('success', 'تم حذف الغرفة بنجاح');
    }

    public function destroyImage(Image $image, ImageService $service)
    {
        $service->delete($image);

        return back();
    }
}

