<?php

use App\Http\Controllers\user\RoomController;
use App\Http\Controllers\user\homeController;
use App\Http\Controllers\user\CategoryController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;



Route::get('home',[homeController::class,'home'])->middleware('no.back.cache')->name('user.home');
Route::get('sections',[homeController::class,'sections'])->name('sections');
Route::get('contact',[homeController::class,'contact'])->name('contact');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->middleware('no.back.cache')->name('categories.show');
Route::get('/all_rooms', [RoomController::class, 'index'])->middleware('no.back.cache')->name('all_rooms');   
Route::get('/show_room/{id}', [RoomController::class, 'show'])->middleware('no.back.cache')->name('show_room');
Route::get('/ajax-search', [RoomController::class, 'ajaxSearch'])->name('rooms.ajax.search');

    
Route::get('/cart', [CartController::class, 'index'])->middleware('no.back.cache')->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    


Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('no.back.cache')->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-success/{order}', [CheckoutController::class, 'orderSuccess'])->name('order.success');
Route::post('/order-success/{order}', [CheckoutController::class, 'orderRegistration'])->name('order.registration');

Route::get('/my-orders', [OrderController::class, 'index'])->middleware('auth-user')->name('user.orders');
Route::delete('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->middleware('auth-user')->name('user.orders.cancel');
    
   

Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');