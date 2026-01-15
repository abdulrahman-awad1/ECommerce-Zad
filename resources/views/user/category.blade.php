@extends('layouts.master')

@push('styles')
<style>
    /* التعديلات المخصصة للموبايل */
    @media (max-width: 768px) {
        .page-container {
            margin: 20px auto !important; /* تقليل الهوامش العلوية */
            padding: 0 10px !important;
        }

        .section-title {
            font-size: 1.4rem !important;
            margin-bottom: 20px !important;
            border-right-width: 4px !important;
        }

        /* نظام عنصرين بجانب بعض */
        .products-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }

        /* تعديل كارت المنتج */
        .room-card {
            border-radius: 12px !important;
            margin-bottom: 5px !important;
        }

        .image-wrapper img {
            height: 160px !important; /* ارتفاع مناسب للصورة في الموبايل */
            object-fit: cover;
        }

        .card-body {
            padding: 10px !important;
        }

        .room-name {
            font-size: 0.9rem !important;
            display: -webkit-box;
            -webkit-line-clamp: 1; /* سطر واحد للاسم */
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 5px !important;
        }

        .room-desc {
            display: none !important; /* إخفاء الوصف لتوفير مساحة */
        }

        .price-row {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 2px !important;
            margin-bottom: 10px !important;
        }

        .price-main {
            font-size: 0.9rem !important;
        }

        .price-old {
            font-size: 0.75rem !important;
        }

        /* تعديل زر السلة */
        .room-card .cta-btn {
            padding: 8px 5px !important;
            font-size: 0.75rem !important;
            width: 100% !important;
        }
        
        .room-card .cta-btn i {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

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

                        <span class="room-name">{{$room->room_name}}</span>
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
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

                            
                            <button type="submit" class="cta-btn" style="padding: 10px 20px; font-size: 0.9em; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-shopping-basket"></i> أضف للعربة
                            </button>
                        </form>

                    </div>

                </a>

            @endforeach
        </div>

</div>
@endsection