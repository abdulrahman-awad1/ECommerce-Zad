@extends('layouts.master')

@section('title', 'إتمام الشراء')

@push('styles')
<style>
    .checkout-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: 'Cairo', sans-serif; }
    .section-title { border-right: 5px solid var(--color-gold); padding-right: 15px; margin-bottom: 30px; }
    
    .checkout-wrapper { display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; align-items: start; }
    
    .checkout-card { background: #fff; border: 1px solid #eee; border-radius: 15px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.02); margin-bottom: 20px; }
    .card-h3 { margin-bottom: 25px; font-size: 1.25rem; color: #333; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f5f5f5; padding-bottom: 15px; }
    .card-h3 i { color: var(--color-gold); }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 0.95rem; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; transition: 0.3s; }
    .form-control:focus { border-color: var(--color-gold); outline: none; box-shadow: 0 0 0 3px rgba(200, 164, 97, 0.1); }

    .order-summary-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f9f9f9; }
    .product-img { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; }
    
    .total-row { display: flex; justify-content: space-between; padding-top: 15px; margin-top: 15px; border-top: 2px solid #f5f5f5; font-weight: 800; font-size: 1.2rem; color: var(--color-gold); }

    .btn-confirm-order { width: 100%; background: var(--color-gold); color: #fff; border: none; padding: 15px; border-radius: 10px; font-size: 1.1rem; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s; }
    .btn-confirm-order:hover { background: #b08d4b; transform: translateY(-2px); }

    /* --- تعديلات الموبايل --- */
    @media (max-width: 992px) {
        .checkout-wrapper { grid-template-columns: 1fr; } /* تحويل لعمود واحد */
        .order-summary-card { order: -1; } /* ملخص الطلب يظهر في الأعلى أولاً في الموبايل */
        
        .checkout-container { margin: 20px auto; }
        .section-title { font-size: 1.6rem; }
        
        .grid-mobile-1 { grid-template-columns: 1fr !important; gap: 10px !important; } /* كسر الشبكة الداخلية */
        
        .checkout-card { padding: 15px; }
        .form-control { padding: 10px; }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <h1 class="section-title">إتمام الطلب</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-wrapper">
            
            {{-- بيانات العميل --}}
            <div class="checkout-info">
                <div class="checkout-card">
                    <h3 class="card-h3"><i class="fas fa-truck"></i> بيانات الشحن والتوصيل</h3>

                    <div class="grid-mobile-1" style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group">
                            <label>الاسم الكامل</label>
                            <input type="text" name="full_name" class="form-control" 
                                   value="{{ auth()->check() ? auth()->user()->name : old('full_name') }}" 
                                   placeholder="أدخل اسمك بالكامل" required>
                        </div>

                        <div class="form-group">
                            <label>رقم الهاتف</label>
                            <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
                               {{ auth()->check() ? 'readonly' : '' }} 
                               placeholder="example@mail.com" required>
                        @auth
                            <small style="color: #6c757d; font-size: 0.75rem;">(يتم ربط الطلب بحسابك المسجل)</small>
                        @endauth
                    </div>

                    <div class="grid-mobile-1" style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group">
                            <label>الدولة</label>
                            <input type="text" name="country" class="form-control" value="مصر" required>
                        </div>
                        <div class="form-group">
                            <label>المحافظة</label>
                            <input type="text" name="city" class="form-control" placeholder="مثلاً: القاهرة" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>العنوان بالتفصيل</label>
                        <textarea name="street" class="form-control" rows="3" placeholder="اسم الشارع، رقم المبنى، علامة مميزة" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>طريقة الدفع</label>
                        <select name="payment_method" class="form-control" required style="background-color: #fdfdfd;">
                            <option value="cash">نقداً تبعاً للشروط</option>
                            <option value="online">دفع إلكتروني </option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ملخص الطلب --}}
            <div class="order-summary-card">
                <div class="checkout-card" style="position: sticky; top: 20px;">
                    <h3 class="card-h3"><i class="fas fa-shopping-bag"></i> ملخص طلبك</h3>

                    @php $total = 0; @endphp
                    <div class="items-preview" style="max-height: 250px; overflow-y: auto; margin-bottom: 20px; padding-left: 5px;">
                        @foreach($items as $item)
                            @php
                                $room = $item->room;
                                $subtotal = $room->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <div class="order-summary-item">
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <img src="{{ $item->room->images->first()->image_path
                                        ? asset('images/uploads/' . $item->room->images->first()->image_path)
                                        : asset('images/no-image.jpg') }}" class="product-img">
                                    <div>
                                        <div style="font-weight: 700; color: #333; font-size: 0.9rem;">{{ $room->room_name }}</div>
                                        <div style="font-size: 0.8rem; color: #888;">الكمية: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <div style="font-weight: 700; font-size: 0.9rem;">{{ number_format($subtotal) }} ج.م</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-summary-item" style="border: none; padding: 5px 0;">
                        <span style="color: #666;">إجمالي المنتجات</span>
                        <span>{{ number_format($total) }} ج.م</span>
                    </div>
                    
                    <div class="order-summary-item" style="border: none; padding: 5px 0;">
                        <span style="color: #666;">تكلفة الشحن</span>
                        <span style="color: #27ae60; font-size: 0.85rem;">يحدد لاحقاً عند تواصل خدمة العملاء معك</span>
                    </div>

                    <div class="total-row">
                        <span>الإجمالي</span>
                        <span>{{ number_format($total) }} ج.م</span>
                    </div>

                    <div style="margin-top: 20px; padding: 12px; background: #fff9eb; border-radius: 8px; font-size: 0.85rem; color: #856404; line-height: 1.5;">
                        <i class="fas fa-info-circle"></i> سيتم تواصل خدمة العملاء معك  لتأكيد تكلفة الشحن وموعد الوصول.
                    </div>

                    <button type="submit" class="btn-confirm-order">
                        تأكيد الطلب الآن <i class="fas fa-check-double" style="margin-right: 5px;"></i>
                    </button>
                    
                    <a href="{{ route('cart.index') }}" style="display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.85rem;">
                        <i class="fas fa-edit"></i> تعديل محتويات السلة
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection