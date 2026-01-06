<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Notifications\OrderStatusUpdatedNotification;


class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.room', 'address', 'user']);
    
        // 1. تجهيز خيارات الحالة (لتجنب الـ if داخل السلكت)
        $status_options = [
            'pending'    => 'قيد الانتظار',
            'processing' => 'جاري التجهيز',
            'delivering' => 'تم الشحن',
            'completed'  => 'مكتمل',
            'cancelled'  => 'إلغاء الطلب',
        ];
    
        // 2. إضافة صفات محسنة للموديل (أو تحويلها لـ Array)
        $order->status_label = $status_options[$order->status] ?? $order->status;
        $order->customer_name = $order->user->name ?? 'غير مسجل';
        $order->customer_email = $order->user->email ?? '-';
        $order->customer_phone = $order->address->phone ?? $order->user->phone ?? 'لا يوجد';
        $order->formatted_date = $order->created_at->format('Y-m-d');
        $order->formatted_time = $order->created_at->format('h:i A');
        $order->formatted_total = number_format($order->total_price);
        $order->has_address = (bool)$order->address;
    
        // 3. تجهيز العناصر المطلوبة
        $order_items = $order->items->map(function ($item) {
            return [
                'image'              => ($item->room && $item->room->images->first()) ? asset('images/uploads/' . $item->room->images->first()->image_path) : asset('images/no-image.jpg'),
                'name'               => $item->room->room_name ?? 'منتج غير متوفر',
                'sku'                => $item->room->sku ?? 'N/A',
                'price_formatted'    => number_format($item->price),
                'quantity'           => $item->quantity,
                'subtotal_formatted' => number_format($item->price * $item->quantity),
            ];
        });
        $total = number_format($order->total_price);
    
        return view('admin.orders_show', compact('order', 'status_options', 'order_items','total'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivering,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);
        $user = $order->user;
    if ($user) {
        $user->notify(new OrderStatusUpdatedNotification($order));
        }

        return back()->with('success', 'تم تحديث حالة الطلب');
    }
}
