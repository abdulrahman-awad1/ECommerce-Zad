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
    public function add(Request $request, CartService $cartService)
    {
        $roomId = $request->room_id;
        $qty = $request->qty ?? 1;

        $room = Room::findOrFail($roomId);

        $cartToken = $cartService->getCartToken();

        $cartItem = Cart::where('cart_token', $cartToken)
            ->where('room_id', $room->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $qty;
            $cartItem->save();
        } else {
            Cart::create([
                'cart_token' => $cartToken,
                'room_id'    => $room->id,
                'price'      => $room->price,
                'quantity'   => $qty,
            ]);
        }

        return back()->with('success', 'تمت الإضافة إلى السلة');
    }

    public function index(CartService $cartService )
    {
        $price = $cartService->getFormattedItems();
        $items = $cartService->getCartItems();
    
        $total = $items->sum(function ($item) {
            return $item->room->price * $item->quantity;
        });
    
        return view('user.cart', [
            'price' => $price,
            'items' => $items,
            'total' => $total,
            'isEmpty' => $items->isEmpty(),
        ]);
    }
    
    

    public function update(Request $request, CartService $cartService)
{
    $request->validate([
        'cart_id'  => 'required|exists:cart,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $cartToken = $cartService->getCartToken();

    Cart::where('id', $request->cart_id)
        ->where('cart_token', $cartToken)
        ->update([
            'quantity' => $request->quantity
        ]);

    return back()->with('success', 'تم تحديث الكمية');
}



public function remove(Request $request, CartService $cartService)
{
    $request->validate([
        'cart_id' => 'required|exists:cart,id'
    ]);

    $cartToken = $cartService->getCartToken();

    Cart::where('id', $request->cart_id)
        ->where('cart_token', $cartToken)
        ->delete();

    return back()->with('success', 'تم الحذف من السلة');
}




}
