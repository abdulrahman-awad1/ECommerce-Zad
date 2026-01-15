<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }

    public function cancel($id)
{
    $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    if ($order->status !== 'pending') {
        return back()->with('error', 'عذراً، لا يمكن إلغاء الطلب بعد اعتماده أو شحنه.');
    }

    $order->update(['status' => 'cancelled']); 

    return back()->with('success', 'تم إلغاء الطلب بنجاح.');
}

}
