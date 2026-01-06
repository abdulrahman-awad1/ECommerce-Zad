<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $order) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statuses = [
            'pending' => 'قيد الانتظار',
            'processing' => 'جاري تجهيز طلبك',
            'delivered' => 'تم شحن طلبك وهو في الطريق إليك',
            'completed' => 'تم توصيل طلبك بنجاح، شكراً لثقتك بنا',
            'cancelled' => 'للأسف، تم إلغاء طلبك',
        ];

        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'message' => 'تحديث للطلب #' . $this->order->id . ': ' . ($statuses[$this->order->status] ?? $this->order->status),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
