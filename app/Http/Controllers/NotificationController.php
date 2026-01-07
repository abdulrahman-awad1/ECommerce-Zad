<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('user.orders');
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    public function adminRead($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    // التحقق من وجود order_id للتوجيه لصفحة تفاصيل الطلب أو الرجوع للخلف
    if (isset($notification->data['order_id'])) {
        return redirect()->route('admin.orders.show', $notification->data['order_id']);
    }

    return back();
}
}
