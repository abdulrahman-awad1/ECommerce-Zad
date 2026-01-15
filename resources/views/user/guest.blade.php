@extends('layouts.master')

@section('title', 'الرئيسية')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* التعديلات الخاصة بالموبايل فقط */
        @media (max-width: 768px) {
            /* 1. تصغير الصورة الرئيسية (Hero Section) */
            .hero-section {
                height: 300px !important; /* تقليل الارتفاع الإجمالي */
                min-height: 300px !important;
            }
            .hero-section img {
                height: 300px !important;
                object-fit: cover;
            }
            .hero-overlay h1 {
                font-size: 1.4rem !important; /* تصغير العنوان */
                margin-bottom: 10px !important;
            }
            .hero-overlay p {
                font-size: 0.85rem !important;
                margin-bottom: 15px !important;
                padding: 0 10px;
            }
            .hero-section .cta-btn {
                padding: 8px 15px !important;
                font-size: 0.85rem !important;
            }

            /* 2. نظام عرض عنصرين بجانب بعض */
            .products-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important; /* عمودين متساويين */
                gap: 12px !important; /* مسافة بين العناصر */
                padding: 10px !important;
            }

            /* 3. تعديل حجم كروت المنتجات */
            .room-card {
                margin-bottom: 5px !important;
                border-radius: 12px !important;
                overflow: hidden;
            }
            .image-wrapper img {
                height: 160px !important; /* تصغير ارتفاع صورة المنتج */
                object-fit: cover;
            }

            /* 4. تعديل نصوص وتفاصيل الكارت */
            .card-body {
                padding: 10px !important;
            }
            .room-name {
                font-size: 0.9rem !important;
                height: auto !important;
                margin-bottom: 5px !important;
                display: -webkit-box;
                -webkit-line-clamp: 1; /* جعل الاسم سطر واحد */
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .room-desc {
                display: none; /* إخفاء الوصف في الموبايل لتوفير مساحة */
            }
            .whatsapp-float { bottom: 80px; right: 20px; }
            .price-row {
                flex-direction: column !important; /* وضع السعر القديم تحت الجديد */
                align-items: flex-start !important;
                gap: 2px !important;
                margin-bottom: 8px !important;
            }
            .price-main {
                font-size: 0.9rem !important;
            }
            .price-old {
                font-size: 0.75rem !important;
            }

            /* 5. تعديل زر السلة داخل الكارت */
            .room-card .cta-btn {
                padding: 8px 5px !important;
                font-size: 0.75rem !important;
                width: 100% !important;
                gap: 5px !important;
            }
            .room-card .cta-btn i {
                font-size: 0.8rem;
            }

            /* 6. تعديل كروت الأقسام */
            .category-card.icon-card {
                padding: 15px 10px !important;
            }
            .category-card.icon-card h3 {
                font-size: 0.9rem !important;
            }
            
            /* تقليل الحوامش العامة للسكشن */
            section {
                padding: 30px 0 !important;
            }
            .section-heading {
                font-size: 1.5rem !important;
                margin-bottom: 20px !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-section">
        <img src="{{asset('images/Gemini_Generated_Image_inuhawinuhawinuh.png')}}" alt="Hero">
        <div class="hero-overlay">
            <h1>أناقة لا تنتهي بلمسة ذهبية</h1>
            <p>اكتشف مجموعتنا الحصرية من الأثاث المصمم بعناية فائقة.</p>
            <a href="{{ route('all_rooms') }}" class="cta-btn">تسوق التشكيلة</a>
        </div>
    </section>

    <section class="new-arrivals" style="padding: 60px 0; background: var(--color-light-grey);">
    <div class="container">
        <h2 class="section-heading">أحدث المنتجات</h2>
        <div class="products-grid">
            @foreach($latestRooms as $room)

                <a href="{{ route('show_room', $room->id) }}" class="room-card">

                    <div class="image-wrapper">

                        @if($room->is_featured)
                            <div class="featured-tag">مميز</div>
                        @endif

                        @if($room->discount > 0)
                                 <div class="discount-tag">
                                    خصم {{ round(($room->discount / ($room->price + $room->discount)) * 100) }}%
                                 </div>
                            @endif

                        <img src="{{ asset('images/uploads/' . ($room->images->first()->image_path ?? 'default.jpg')) }}" alt="{{ $room->room_name }}">
                    </div>

                    <div class="card-body">

                        <span class="room-name">{{ $room->room_name }}</span>
                        <p class="room-desc">{{ $room->description }}</p>

                        <div class="price-row">
                            <span class="price-main">{{ number_format($room->price) }} ج.م</span>

                            @if($room->discount > 0)
                                    <span class="price-old">{{number_format($room->price + $room->discount) }}</span>
                                @endif
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            
                            <button type="submit" class="cta-btn" style="padding: 10px 20px; font-size: 0.9em; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-shopping-basket"></i> أضف للعربة
                            </button>
                        </form>

                    </div>

                </a>

            @endforeach
        </div>
    </div>
</section>

    <section class="new-arrivals" style="padding: 60px 0; background: var(--color-light-grey);">
        <div class="container">
            <h2 class="section-heading">المميزة </h2>
            <div class="products-grid">
            @foreach($featuredRooms as $room)

                <a href="{{ route('show_room', $room->id) }}" class="room-card">

                    <div class="image-wrapper">

                        @if($room->is_featured )
                            <div class="featured-tag">مميز</div>
                        @endif

                        @if($room->discount > 0)
                                    <span class="price-old">{{number_format($room->price + $room->discount) }}</span>
                                @endif

                        <img src="{{ asset('images/uploads/' . ($room->images->first()->image_path ?? 'default.jpg')) }}" alt="{{ $room->room_name }}">
                    </div>

                    <div class="card-body">

                        <span class="room-name">{{ $room->room_name }}</span>
                        <p class="room-desc">{{ $room->description }}</p>

                        <div class="price-row">
                            <span class="price-main">{{ number_format($room->price) }} ج.م</span>

                            @if($room->price)
                                <span class="price-old">{{number_format($room->price + $room->discount) }}</span>
                            @endif
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            
                            <button type="submit" class="cta-btn" style="padding: 10px 20px; font-size: 0.9em; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-shopping-basket"></i> أضف للعربة
                            </button>
                        </form>

                    </div>

                </a>

            @endforeach
        </div>
        </div>
    </section>


    <section class="categories-showcase container" style="padding: 60px 0;">
        <h2 class="section-heading">استكشف أقسامنا</h2>
        <div class="products-grid">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}">
                    <div class="category-card icon-card">
                        <i class="fas fa-layer-group"></i>
                        <h3 style="font-size: 1.2em;">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection