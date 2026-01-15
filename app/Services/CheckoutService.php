<?php
namespace App\Services;
use App\Services\CartService;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\NewOrderNotification;



class CheckoutService
{
    public function __construct(private CartService $cartService) {}

    public function createOrder($request): Order
    {
        return DB::transaction(function () use ($request) {

            $items = $this->cartService->items();

            if ($items->isEmpty()) {
                throw new \Exception('Cart empty');
            }

            $order = Order::create([
                'order_number' => Str::upper(Str::random(10)),
                'user_id' => auth()->id(),
                'cart_token' => $this->cartService->getCartToken(),
                'total_price' => $this->cartService->total(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'room_id' => $item->room_id,
                    'room_name' => $item->room->room_name,
                    'price' => $item->room->price,
                    'quantity' => $item->quantity,
                    'total' => $item->room->price * $item->quantity,
                ]);
            }

            OrderAddress::create([
                'order_id' => $order->id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'street' => $request->street,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);
            // 5. إخطار الإدارة وتنظيف السلة 
            $admin = User::where('role', 'admin')->first();
             if ($admin) {
                 $admin->notify(new NewOrderNotification($order));
                 }

            $this->cartService->clear();

            return $order;
        });
    }

    public function registerUserForOrder($request, Order $order): void
    {
        DB::transaction(function () use ($request, $order) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            $order->update(['user_id' => $user->id]);

            auth()->login($user);
        });
    }
}
