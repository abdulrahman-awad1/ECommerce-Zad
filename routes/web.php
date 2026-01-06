<?php

use App\Http\Controllers\admin\RoomController;
use App\Http\Controllers\user\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[homeController::class,'home'])->name('home');







require __DIR__.'/user.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

