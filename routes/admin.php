<?php

use App\Http\Controllers\admin\RoomController;
use App\Http\Controllers\admin\adminHomeController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Models\Room;



Route::get('/rooms', [RoomController::class, 'index'])->middleware('admin')->name('rooms.index');
Route::get('room.create',[RoomController::class,'create'])->middleware('admin')->name('create');
Route::post('rooms.store',[RoomController::class,'store'])->middleware('admin')->name('rooms.store');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->middleware('admin')->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->middleware('admin')->name('rooms.update');
Route::delete('/room/{room}', [RoomController::class, 'destroy'])->middleware('admin')->name('rooms.destroy');
Route::delete('/images/{image}', [RoomController::class, 'destroy_image'])->middleware('admin')->name('images.destroy');
Route::get('rooms/{room}', [RoomController::class, 'show'])->middleware('admin')->name('rooms.show');

Route::get('/sections/{category}', [adminHomeController::class, 'category'])->middleware('admin')->name('rooms.category');
Route::get('admin.sections',[adminHomeController::class,'sections'])->middleware('admin')->name('admin.sections');

// routes/web.php
Route::middleware('admin')->group(function () {

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

      
});

// رابط قراءة إشعارات الأدمن
Route::get('/admin/notifications/{id}/read', [NotificationController::class, 'adminRead'])->name('admin.notifications.read');