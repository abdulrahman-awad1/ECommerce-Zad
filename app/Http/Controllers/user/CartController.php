<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Room;
use App\Services\CartService;
use App\Services\RoomService;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        return view('user.cart', [
            'items' => $cart->items(),
            'total' => $cart->total(),
            'isEmpty' => $cart->isEmpty(),
        ]);
    }

    public function add(Request $request, CartService $cart)
    {
        $cart->add($request->room_id, $request->qty ?? 1);
        return redirect()
        ->route('cart.index')
        ->with('success', 'تمت الإضافة إلى السلة');
    
    }

    public function update(Request $request, CartService $cart)
    {
        $cart->updateQuantity($request->cart_id, $request->quantity);

        return redirect(url()->previous())->with('success', 'تم تحديث الكمية');
    }

    public function remove(Request $request, CartService $cart)
    {
        $cart->remove($request->cart_id);

        return redirect(url()->previous())->with('success', 'تم الحذف من السلة');
    }
}

