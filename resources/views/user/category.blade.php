@extends('layouts.master')

@section('content')
<div class="page-container" style="max-width: 1300px; margin: 40px auto; padding: 0 20px;">

    <h1 class="section-title" style="margin-bottom: 30px; border-right: 5px solid var(--color-gold); padding-right: 15px;">
        قسم: {{ $category_name }}
    </h1>

    <div class="products-grid">
            @foreach($rooms as $room)

                <a href="{{ route('show_room', $room->id) }}" class="room-card">

                    <div class="image-wrapper">

                        @if($room->is_featured)
                            <div class="featured-tag">مميز</div>
                        @endif

                        @if($room->is_discounted)
                            <div class="discount-tag">خصم {{ $room->discount_percent }}%</div>
                        @endif

                        <img src="{{ $room->image_url }}" alt="{{ $room->room_name }}">
                    </div>

                    <div class="card-body">

                        <span class="room-name">{{ $room->room_name }}</span>
                        <p class="room-desc">{{ $room->description }}</p>

                        <div class="price-row">
                            <span class="price-main">{{ $room->formatted_price }} ج.م</span>

                            @if($room->old_price)
                                <span class="price-old">{{ $room->old_price }}</span>
                            @endif
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            
                            {{-- استخدمنا نفس كلاس الـ cta-btn لضمان ثبات الشكل مع تعديل بسيط للزر --}}
                            <button type="submit" class="cta-btn" style="padding: 10px 20px; font-size: 0.9em; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-shopping-basket"></i> أضف إلى العربة
                            </button>
                        </form>

                    </div>

                </a>

            @endforeach
        </div>

</div>
@endsection
