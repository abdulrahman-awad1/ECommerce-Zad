@extends('layouts.master')

@section('title', 'طلباتي')

@push('styles')
<style>
    .orders-container { max-width: 1000px; margin: 40px auto; padding: 0 20px; font-family: 'Cairo', sans-serif; }
    .page-title { border-right: 5px solid #C8A461; padding-right: 15px; margin-bottom: 30px; font-weight: bold; }
    
    .order-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 20px; margin-bottom: 20px; transition: 0.3s; }
    .order-card:hover { shadow: 0 5px 15px rgba(0,0,0,0.05); }
    
    .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5; padding-bottom: 15px; margin-bottom: 15px; }
    .order-id { font-weight: bold; color: #C8A461; }
    .order-status { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; background: #fdfaf4; color: #856404; }
    
    .order-item { display: flex; align-items: center; gap: 15px; margin-bottom: 10px; }
    .order-item img { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; }
    
    .order-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px dotted #eee; }
    .total-price { font-weight: 800; font-size: 1.1rem; }
   
</style>
@endpush

@section('content')

<div class="orders-container">
    <h2 class="page-title">قائمة طلباتي</h2>

    @if($orders->isEmpty())
        <div style="text-align: center; padding: 50px;">
            <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc;"></i>
            <p style="margin-top: 15px; color: #888;">لم تقم بإجراء أي طلبات حتى الآن.</p>
            <a href="{{ route('home') }}" class="cta-btn" style="display: inline-block; margin-top: 10px; text-decoration: none;">ابدأ التسوق</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">رقم الطلب: #{{ $order->id }}</span>
                        <div style="font-size: 0.8rem; color: #999;">تاريخ الطلب: {{ $order->created_at->format('Y-m-d') }}</div>
                    </div>
                    <span class="order-status">
                        {{-- هنا يمكنك وضع حالة الطلب من قاعدة البيانات --}}
                        {{ $order->status ?? 'قيد المراجعة' }}
                    </span>
                </div>

                <div class="order-body">
                    @foreach($order->items as $item)
                        <div class="order-item">
                        <img src="{{ $item->room->images->first()->image_path
    ? asset('images/uploads/' . $item->room->images->first()->image_path)
    : asset('images/no-image.jpg') }}">
                            <div>
                                <div style="font-weight: bold;">{{ $item->room->room_name }}</div>
                                <div style="font-size: 0.85rem; color: #777;">الكمية: {{ $item->quantity }} | السعر: {{ number_format($item->price) }} ج.م</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="order-footer">
                    <span>إجمالي المبلغ:</span>
                    <span class="total-price">{{ number_format($order->total_price) }} ج.م</span>
                </div>
                {{-- التحقق من حالة الطلب لإظهار أزرار التحكم --}}
    @if($order->status == 'pending')
        <div class="order-actions" style="display: flex; gap: 10px;">
            {{-- زر التعديل: يوجه العميل للعودة للسلة أو صفحة خاصة (حسب منطق موقعك) --}}
           
            {{-- زر الحذف --}}
            <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn-delete" 
                        style="padding: 5px 15px; background: #e74c3c; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 0.85rem;">
                    <i class="fas fa-trash"></i> إلغاء الطلب
                </button>
            </form>
        </div>
    @endif
            </div>
        @endforeach
    @endif
</div>
@endsection