@extends('layouts.master')

@section('title', 'إتمام الشراء')



@section('content')
<div class="checkout-container">
    <h1 class="section-title">إتمام الطلب</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-wrapper">
            {{-- بيانات العميل --}}
            <div class="checkout-card">
    <h3 class="card-h3">بيانات الشحن والتوصيل</h3>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div class="form-group">
            <label>الاسم الكامل</label>
            <input type="text" name="full_name" class="form-control" 
                   value="{{ auth()->check() ? auth()->user()->name : old('full_name') }}" 
                   placeholder="أدخل اسمك بالكامل" required>
                   
                   
        </div>


        <div class="form-group">
            <label>رقم الهاتف</label>
            <input type="tel" name="phone" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" class="form-control" 
               value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
               {{ auth()->check() ? 'readonly' : '' }} 
               placeholder="example@mail.com" required>
        @auth
            <small style="color: #6c757d;">(يتم استخدام بريدك المسجل لضمان ربط الطلب بحسابك)</small>
        @endauth
    </div>

    <div class="form-group">
        <label>الدولة</label>
        <input type="text" name="country" class="form-control" required>
    </div>
    <div class="form-group">
        <label>المحافظة</label>
        <input type="text" name="city" class="form-control" required>
    </div>


    <div class="form-group">
        <label>العنوان بالتفصيل</label>
        <textarea name="street" class="form-control" rows="3" required></textarea>
    </div>


    <div class="form-group">
        <label>طريقة الدفع</label>
        <select name="payment_method" class="form-control" required>
            <option value="cash">نقداً عند الاستلام</option>
            <option value="online">دفع إلكتروني</option>
        </select>
    </div>
</div>


            {{-- ملخص الطلب --}}
            <div class="order-summary-card">
                <div class="checkout-card" style="position: sticky; top: 20px;">
                    <h3 class="card-h3"><i class="fas fa-shopping-bag"></i> ملخص طلبك</h3>

                    @php $total = 0; @endphp
                    <div class="items-preview" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach($items as $item)
                            @php
                                $room = $item->room;
                                $subtotal = $room->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <div class="order-summary-item">
                                <div style="display: flex; gap: 15px;">
                                <img src="{{ $item->room->images->first()->image_path
    ? asset('images/uploads/' . $item->room->images->first()->image_path)
    : asset('images/no-image.jpg') }}"class="product-img">
                                    <div>
                                        <div style="font-weight: 700; color: #333;">{{ $room->room_name }}</div>
                                        <div style="font-size: 0.85rem; color: #888;">الكمية: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <div style="font-weight: 700;">{{ $subtotal }} ج.م</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-summary-item" style="border: none; margin-bottom: 5px;">
                        <span>إجمالي المنتجات</span>
                        <span>{{ $total }} ج.م</span>
                    </div>
                    
                    <div class="order-summary-item" style="border: none;">
                        <span>تكلفة الشحن</span>
                        <span style="color: #27ae60;">يحدد لاحقاً</span>
                    </div>

                    <div class="total-row">
                        <span>الإجمالي الكلي</span>
                        <span>{{ $total }} ج.م</span>
                    </div>

                    <div style="margin-top: 25px; padding: 15px; background: #fff9eb; border-radius: 8px; font-size: 0.9rem; color: #856404;">
                        <i class="fas fa-info-circle"></i> الدفع يكون عند الاستلام أو عبر التحويل البنكي بعد تواصل خدمة العملاء معك.
                    </div>

                    <button type="submit" class="btn-confirm-order">
                        تأكيد الطلب الآن <i class="fas fa-check-double"></i>
                    </button>
                    
                    <a href="{{ route('cart.index') }}" style="display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-arrow-right"></i> العودة لتعديل السلة
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
