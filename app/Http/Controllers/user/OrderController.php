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

    // تأكد مرة أخرى من الحالة برمجياً قبل الحذف
    if ($order->status !== 'pending') {
        return back()->with('error', 'عذراً، لا يمكن إلغاء الطلب بعد اعتماده أو شحنه.');
    }

    $order->update(['status' => 'cancelled']); //إذا كنت تفضل الإلغاء بدل الحذف التام

    return back()->with('success', 'تم إلغاء الطلب بنجاح.');
}

// دالة التعديل (مثال بسيط)
public function edit($id)
{
    $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    if ($order->status !== 'pending') {
        return back()->with('error', 'لا يمكن تعديل الطلبات التي تجاوزت مرحلة الانتظار.');
    }

    // هنا يمكنك توجيهه لصفحة تعديل البيانات (مثل العنوان أو رقم الهاتف)
    return view('user.orders_edit', compact('order'));
}
}
