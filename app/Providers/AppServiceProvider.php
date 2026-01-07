<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // إجبار الموقع على استخدام HTTPS في الروابط (لحل مشكلة التنسيق)
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    try {
        // نتأكد أولاً أن جدول المستخدمين موجود عشان ميعملش ايرور وقت الـ Migrate
        if (Schema::hasTable('users')) {
            User::firstOrCreate(
                ['email' => 'Admin@email.com'], // بيبحث بالإيميل ده
                [
                    'name' => 'Admin',
                    'password' => Hash::make('StrongPassword12345'),
                    'role' => 'admin',
                ]
            );
        }
    } catch (\Exception $e) {
        // بنسيبها فاضية عشان الموقع ميعطلش لو حصلت مشكلة في الداتابيز
    }
        
        
        View::composer('*', function ($view) {
            $cartService = app(\App\Services\CartService::class);
        
            $items = $cartService->getCartItems();
        
            $view->with([
                'cartItems' => $items,
                'cartCount' => $items->sum('quantity'),
                'cartTotal' => $items->sum(fn ($item) => $item->room->price * $item->quantity),
            ]);
        });
        

        View::composer('*', function ($view) {
            if (auth()->check()) {
                $view->with([
                    'userNotifications' => auth()->user()->notifications()->latest()->take(10)->get(),
                    'unreadCount' => auth()->user()->unreadNotifications()->count(),
                ]);
            } else {
                $view->with([
                    'userNotifications' => collect(),
                    'unreadCount' => 0,
                ]);
            }
        });
        
    }
}
