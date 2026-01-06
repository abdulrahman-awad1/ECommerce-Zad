<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// عرض صفحة التسجيل
//Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

// تنفيذ التسجيل
Route::post('/register', [AuthController::class, 'register'])->name('register');

// عرض صفحة تسجيل الدخول
//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// تنفيذ تسجيل الدخول
Route::post('/login', [AuthController::class, 'login'])->name('login');

// تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

