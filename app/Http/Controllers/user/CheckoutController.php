<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Order;

use App\Services\CartService;
use App\Services\CheckoutService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\CheckoutRequest;



class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $items = $cartService->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        return view('user.checkout', [
            'items' => $items,
            'total' => $cartService->total(),
        ]);
    }

    public function store(CheckoutRequest $request, CheckoutService $service)
    {
        $order = $service->createOrder($request);

        if (!$order->user_id) {
            return redirect()
                ->route('order.success', ['order' => $order->id]) 
                ->with('show_registration', true);
        }

        return redirect()
            ->route('user.orders')
            ->with('success', 'تم تأكيد الطلب');
    }
    

    public function orderSuccess(Order $order)
    {
        if ($order->user_id && auth()->check()) {
            return redirect()->route('user.orders');
        }

        return view('user.checkout_success', compact('order'));
    }

    public function orderRegistration(RegisterRequest $request, CheckoutService $service, Order $order)
    {
        $service->registerUserForOrder($request, $order);

        return redirect()
            ->route('user.orders')
            ->with('success', 'تم تفعيل الحساب');
    }
}

