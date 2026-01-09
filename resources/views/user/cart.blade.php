@extends('layouts.master')

@section('title', 'سلة التسوق')

@push('styles')
<style>
    .cart-page-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; font-family: 'Cairo', sans-serif; }
    .section-title { border-right: 5px solid var(--color-gold); padding-right: 15px; margin-bottom: 30px; }
    
    /* تنسيق الجدول للكمبيوتر */
    .cart-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .cart-table th { background: #f8f9fa; padding: 15px; text-align: right; color: #555; }
    .cart-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
    .product-img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; }
    
    .qty-stepper { display: flex; align-items: center; gap: 5px; background: #f1f1f1; border-radius: 5px; width: fit-content; }
    .qty-stepper button { border: none; background: none; padding: 5px 12px; cursor: pointer; font-size: 1.2rem; }
    .qty-stepper input { width: 40px; text-align: center; border: none; background: transparent; font-weight: bold; }

    .cart-summary { margin-top: 30px; background: #fff; padding: 25px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .btn-checkout { background: var(--color-gold); color: #fff; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s; }
    .btn-checkout:hover { background: #b08d4b; transform: translateY(-2px); }
    .btn-remove { color: #e74c3c; border: none; background: none; cursor: pointer; font-size: 1.1rem; }

    /* --- تعديلات الموبايل الجوهرية --- */
    @media (max-width: 768px) {
        .cart-table thead { display: none; } /* إخفاء رأس الجدول */
        .cart-table, .cart-table tbody, .cart-table tr, .cart-table td { display: block; width: 100%; }
        
        .cart-table tr { margin-bottom: 20px; border: 1px solid #eee; border-radius: 12px; padding: 10px; position: relative; background: #fff; }
        .cart-table td { border: none; padding: 8px 5px; text-align: center; }
        
        /* جعل الصورة والاسم في الأعلى */
        .cart-table td:first-child { display: flex; justify-content: center; }
        .product-img { width: 120px; height: 120px; }
        
        /* إظهار مسميات البيانات قبل القيم في الموبايل */
        .cart-table td:nth-child(2) { font-size: 1.1rem; }
        .cart-table td:nth-child(4):before { content: "السعر: "; color: #888; font-size: 0.8rem; }
        .cart-table td:nth-child(5):before { content: "الإجمالي: "; color: #888; font-size: 0.8rem; font-weight: normal; }
        .cart-table td.highlight { font-weight: bold; color: var(--color-gold); font-size: 1.1rem; }

        .qty-stepper { margin: 0 auto; }
        .cart-table td:last-child { 
        position: static; /* يرجع لمكانه الطبيعي */
        width: 100%; 
        padding-top: 15px;
        border-top: 1px solid #f5f5f5 !important; /* فاصل بسيط قبل زر الحذف */
    }

    /* 2. تحسين شكل الزر ليكون واضحاً وسهل الضغط */
    .btn-remove {
        background: #fff5f5 !important;
        color: #e74c3c;
        border: 1px solid #ffdada !important;
        padding: 10px 20px !important;
        border-radius: 8px !important;
        width: 100%; 
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 0.95rem;
        cursor: pointer;
    }

    /* 3. إضافة النص بجانب الأيقونة */
    .btn-remove:after {
        content: "حذف من السلة";
        font-family: 'Cairo', sans-serif;
    }
        
        .cart-summary { flex-direction: column; gap: 15px; text-align: center; }
        .btn-checkout { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="cart-page-container">

    <h1 class="section-title">سلة التسوق</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($isEmpty)
        <div style="text-align: center; padding: 60px 20px;">
            <i class="fas fa-shopping-basket" style="font-size: 4rem; color: #eee; margin-bottom: 20px;"></i>
            <p style="color: #888; font-size: 1.2rem;">السلة فارغة حالياً</p>
            <a href="{{ route('home') }}" class="btn-checkout" style="display: inline-block; margin-top: 15px;">ابدأ التسوق الآن</a>
        </div>
    @else

        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->room->images->first()->image_path
                                ? asset('images/uploads/' . $item->room->images->first()->image_path)
                                : asset('images/no-image.jpg') }}" class="product-img">
                        </td>

                        <td>
                            <strong>{{ $item['room_name'] }}</strong>
                        </td>

                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" id="update-form-{{ $item['id'] }}">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">

                                <div class="qty-stepper">
                                    <button type="button" onclick="autoStepQty({{ $item['id'] }}, -1)">−</button>
                                    <input type="number" id="qty-{{ $item['id'] }}" name="quantity" value="{{ $item['quantity'] }}" readonly>
                                    <button type="button" onclick="autoStepQty({{ $item['id'] }}, 1)">+</button>
                                </div>
                            </form>
                        </td>

                        <td>{{ number_format($item->room->price) }} ج.م</td>

                        <td class="highlight"> 
                            {{ number_format($item->room->price * $item->quantity) }} ج.م
                        </td>

                        <td>
    <form action="{{ route('cart.remove') }}" method="POST" style="margin: 0;">
        @csrf
        <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
        <button type="submit" class="btn-remove">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <div>
                <span style="color: #888; margin-left: 10px;">الإجمالي الكلي:</span>
                <strong style="font-size: 1.5rem; color: #333;">{{ number_format($total) }} ج.م</strong>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                إتمام الطلب <i class="fas fa-arrow-left" style="margin-right: 8px; font-size: 0.8rem;"></i>
            </a>
        </div>

    @endif
</div>
@endsection

@push('scripts')
<script>
function autoStepQty(id, change) {
    const input = document.getElementById('qty-' + id);
    const form = document.getElementById('update-form-' + id);

    let value = parseInt(input.value) + change;

    if (value >= 1) {
        input.value = value;
        form.submit();
    }
}
</script>
@endpush