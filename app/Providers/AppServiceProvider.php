<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
