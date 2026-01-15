@extends('layouts.master')

@section('title', 'طلباتي')

@push('styles')
<style>
    .orders-container { max-width: 1000px; margin: 40px auto; padding: 0 20px; font-family: 'Cairo', sans-serif; }
    .page-title { border-right: 5px solid #C8A461; padding-right: 15px; margin-bottom: 30px; font-weight: bold; }
    
    .order-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 20px; margin-bottom: 20px; transition: 0.3s; position: relative; }
    .order-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    
    .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5; padding-bottom: 15px; margin-bottom: 15px; flex-wrap: wrap; gap: 10px; }
    .order-id { font-weight: bold; color: #C8A461; }
    .order-status { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; background: #fdfaf4; color: #856404; font-weight: 600; }
    
    .order-item { display: flex; align-items: center; gap: 15px; margin-bottom: 12px; padding: 10px; background: #fafafa; border-radius: 8px; }
    .order-item img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid #eee; }
    
    .order-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px dotted #eee; }
    .total-price { font-weight: 800; font-size: 1.1rem; color: #2ecc71; }

    /* --- تعديلات الموبايل --- */
    @media (max-width: 768px) {
        .orders-container { margin: 20px auto; padding: 0 15px; }
        .page-title { font-size: 1.5rem; margin-bottom: 20px; }
        
        .order-card { padding: 15px; }
        
        .order-header { flex-direction: column; align-items: flex-start; }
        .order-status { align-self: flex-start; font-size: 0.75rem; }

        .order-item { gap: 10px; padding: 8px; }
        .order-item img { width: 50px; height: 50px; }
        .order-item div { flex: 1; }
        .order-item div b { font-size: 0.9rem; display: block; margin-bottom: 3px; }
        .order-item div span { font-size: 0.75rem !important; }

        .order-footer { font-size: 0.9rem; }
        .total-price { font-size: 1rem; }

        .order-actions { margin-top: 15px; width: 100%; }
        .btn-delete { width: 100%; text-align: center; padding: 10px !important; }
    }
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
                        <div style="font-size: 0.8rem; color: #999; margin-top: 4px;">
                            <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('Y-m-d') }}
                        </div>
                    </div>
                    <span class="order-status">
                        <i class="fas fa-clock"></i> {{ $order->status ?? 'قيد المراجعة' }}
                    </span>
                </div>

                <div class="order-body">
                    @foreach($order->items as $item)
                        <div class="order-item">
                        <img src="{{ $item->room?->images?->first()?->image_path
            ? asset('images/uploads/' . $item->room->images->first()->image_path)
            : asset('images/no-image.jpg') }}"
     class="product-img"
     alt="{{ $item->room?->room_name ?? 'No Name' }}">


                            <div>
                                <b style="font-weight: bold; color: #333;">{{ $item->room_name }}</b>
                                <span style="font-size: 0.85rem; color: #777; display: block;">
                                    الكمية: {{ $item->quantity }} | {{ number_format($item->price) }} ج.م
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="order-footer">
                    <span>إجمالي المبلغ:</span>
                    <span class="total-price">{{ number_format($order->total_price) }} ج.م</span>
                </div>

                {{-- زر الإلغاء في حال كان الطلب قيد الانتظار فقط --}}
                @if($order->status == 'pending' || !$order->status)
                    <div class="order-actions" style="margin-top: 15px;">
                        <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" 
                                    style="padding: 8px 20px; background: #ff4d4d; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-trash-alt"></i> إلغاء الطلب
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection