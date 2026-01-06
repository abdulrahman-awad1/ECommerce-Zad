<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\OrderAddress;
use App\Services\CartService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $cartToken = $cartService->getCartToken();

        $items = Cart::with('room')
            ->where('cart_token', $cartToken)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة!');
        }

        $total = $items->sum(fn($item) => $item->quantity * $item->price);

        return view('user.checkout', compact('items', 'total'));
    }

    public function store(Request $request, CartService $cartService)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:500',
            'zip_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cash,online',
        ]);
    
        $isNewUser = false;
    
        try {
    
            DB::transaction(function () use ($request, $cartService, &$isNewUser) {
    
                // user
                if (!auth()->check()) {
                    $user = User::where('email', $request->email)->first();
    
                    if (!$user) {
                        $isNewUser = true;
    
                        $user = User::create([
                            'name' => $request->full_name,
                            'email' => $request->email,
                            'password' => Hash::make($request->phone),
                            'role' => 'user',
                        ]);
                    }
    
                    auth()->login($user);
                }
    
                $cartToken = $cartService->getCartToken();
    
                $items = Cart::with('room')
                    ->where('cart_token', $cartToken)
                    ->get();
    
                if ($items->isEmpty()) {
                    throw new \Exception('Cart is empty');
                }
    
                $totalPrice = $items->sum(fn ($item) =>
                    $item->quantity * $item->room->price
                );
    
                // order
                $order = Order::create([
                    'order_number' => Str::upper(Str::random(10)),
                    'user_id' => auth()->id(),
                    'cart_token' => $cartToken,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method,
                ]);
    
                // items
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'room_id' => $item->room_id,
                        'room_name' => $item->room->room_name,
                        'price' => $item->room->price,
                        'quantity' => $item->quantity,
                        'total' => $item->quantity * $item->room->price,
                    ]);
                }
    
                // address
                OrderAddress::create([
                    'order_id' => $order->id,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'city' => $request->city,
                    'zip_code' => $request->zip_code,
                    'street' => $request->street,
                    'country' => $request->country,
                ]);
    
                // notify admin
                $admin = User::where('role', 'admin')->first();
                if ($admin) {
                    $admin->notify(new NewOrderNotification($order));
                }
    
                // clear cart
                Cart::where('cart_token', $cartToken)->delete();
            });
    
        } catch (\Throwable $e) {
    
            dd($e->getMessage());
        }
    
        $msg = $isNewUser
            ? 'تم تأكيد الطلب. تم إنشاء حساب لك وكلمة المرور هي رقم الهاتف'
            : 'تم تأكيد الطلب بنجاح';
    
        return redirect()
            ->route('user.orders')
            ->with('success', $msg);
    }
    
}
