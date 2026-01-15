<?php
namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\Room;
use App\Models\Order;
use Illuminate\Support\Collection;

class CartService
{
    public function getCartToken(): string
    {
        $token = request()->cookie('cart_token');

        if (!$token) {
            $token = (string) Str::uuid();
            Cookie::queue('cart_token', $token, 60 * 24 * 30);
        }

        return $token;
    }

    public function items(): Collection
    {
        return Cart::with('room.images')
            ->where('cart_token', $this->getCartToken())
            ->get();
    }

    public function formattedItems(): Collection
    {
        return $this->items()->map(function ($item) {
            $room = $item->room;

            return (object) [
                'id' => $item->id,
                'room_name' => $room->room_name,
                'quantity' => $item->quantity,
                'price' => $room->price,
                'subtotal' => $room->price * $item->quantity,
                'image' => $room->images->first()
                    ? asset('images/uploads/' . $room->images->first()->image_path)
                    : asset('images/no-image.jpg'),
            ];
        });
    }

    public function total(): int
    {
        return $this->formattedItems()->sum('subtotal');
    }

    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }

    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    public function add(int $roomId, int $qty = 1): void
    {
        $room = Room::findOrFail($roomId);

        $item = Cart::where('cart_token', $this->getCartToken())
            ->where('room_id', $roomId)
            ->first();

        if ($item) {
            $item->increment('quantity', $qty);
            return;
        }

        Cart::create([
            'cart_token' => $this->getCartToken(),
            'room_id' => $roomId,
            'price' => $room->price,
            'quantity' => $qty,
        ]);
    }

    public function updateQuantity(int $cartId, int $qty): void
    {
        Cart::where('id', $cartId)
            ->where('cart_token', $this->getCartToken())
            ->update(['quantity' => $qty]);
    }

    public function remove(int $cartId): void
    {
        Cart::where('id', $cartId)
            ->where('cart_token', $this->getCartToken())
            ->delete();
    }
    public function clear()
    {
        $cartToken = $this->getCartToken();
        Cart::where('cart_token', $cartToken)->delete();
    }
}
