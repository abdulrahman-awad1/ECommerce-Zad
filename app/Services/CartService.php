<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\Room;


class CartService
{
    public function getCartToken()
    {
        $token = request()->cookie('cart_token');

        if (!$token) {
            $token = Str::uuid()->toString();
            Cookie::queue('cart_token', $token, 60 * 24 * 30);
        }

        return $token;
    }

    public function getCartItems()
    {
        return Cart::with(['room.images'])
            ->where('cart_token', $this->getCartToken())
            ->get();
    }

    public function getFormattedItems()
    {
        return $this->getCartItems()->map(function ($item) {
            $price = $item->room->price;
            $quantity = $item->quantity;

            return [
                'id' => $item->id,
                'room_name' => $item->room->room_name,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $price * $quantity,
                'image' => $item->room->images->first()->image_path
                    ?? asset('images/no-image.jpg'),
            ];
        });
    }

    public function getTotal()
    {
        return $this->getFormattedItems()->sum('subtotal');
    }

    public function isEmpty()
    {
        return $this->getCartItems()->isEmpty();
    }

    public function getCount()
    {
        return $this->getCartItems()->sum('quantity');
    }
}
