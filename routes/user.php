<?php

use App\Http\Controllers\user\RoomController;
use App\Http\Controllers\user\homeController;
use App\Http\Controllers\user\CategoryController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;



Route::get('home',[homeController::class,'home'])->name('home');
Route::get('sections',[homeController::class,'sections'])->name('sections');
Route::get('contact',[homeController::class,'contact'])->name('contact');
Route::get('/rooms/search', [homeController::class, 'search'])->name('rooms.search');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/all_rooms', [RoomController::class, 'index'])->name('all_rooms');   
Route::get('/show_room/{id}', [RoomController::class, 'show'])->name('show_room');
Route::get('/ajax-search', [RoomController::class, 'ajaxSearch'])->name('rooms.ajax.search');

    
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    
// عرض صفحة الدفع
// Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// // معالجة الدفع (مثال: تأكيد الطلب)
// Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


//Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [OrderController::class, 'index'])->middleware('auth-user')->name('user.orders');
    
    // مسار إلغاء (حذف) الطلب
    Route::delete('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');
    
    // مسار تعديل الطلب (اختياري: يمكن توجيهه لصفحة تعرض الطلب مرة أخرى)
    Route::get('/my-orders/{id}/edit', [OrderController::class, 'edit'])->name('user.orders.edit');
//});



// رابط قراءة إشعار واحد


Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');

// رابط تحديد الكل كمقروء
Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');