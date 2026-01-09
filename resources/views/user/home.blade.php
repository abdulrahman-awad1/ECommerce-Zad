@extends('layouts.master')

@section('title', 'الرئيسية')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* --- تعديلات الموبايل الإضافية --- */
        @media (max-width: 768px) {
            /* 1. تصغير الصورة الرئيسية (Hero Section) */
            .hero-section {
                height: 300px !important; /* تقليل الارتفاع */
                min-height: 300px !important;
            }
            .hero-section img {
                height: 300px !important;
                object-fit: cover;
            }
            .hero-overlay h1 {
                font-size: 1.4rem !important; /* تصغير العنوان */
            }
            .hero-overlay p {
                font-size: 0.9rem !important;
                margin-bottom: 15px !important;
            }
            .hero-section .cta-btn {
                padding: 8px 15px !important;
                font-size: 0.85rem !important;
            }

            /* 2. جعل المنتجات تظهر عنصرين بجانب بعض (Grid) */
            .products-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important; /* عنصرين في الصف */
                gap: 10px !important; /* تقليل المسافات */
                padding: 10px !important;
            }

            /* 3. تعديل حجم كارت المنتج ليناسب المساحة الصغيرة */
            .room-card {
                margin-bottom: 0 !important;
                border-radius: 10px !important;
            }
            .room-card img {
                height: 150px !important; /* تصغير ارتفاع صورة المنتج */
            }
            .card-body {
                padding: 10px !important;
            }
            .room-name {
                font-size: 0.9rem !important; /* تصغير الاسم */
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .room-desc {
                display: none; /* إخفاء الوصف في الموبايل لتوفير مساحة */
            }
            .price-main {
                font-size: 0.85rem !important;
            }
            .price-old {
                font-size: 0.7rem !important;
            }
            
            /* 4. تعديل زر "أضف للعربة" في الكارت الصغير */
            .room-card .cta-btn {
                padding: 6px 5px !important;
                font-size: 0.75rem !important;
                border-radius: 5px !important;
            }
            .room-card .cta-btn i {
                font-size: 0.8rem;
            }

            /* 5. تصغير قسم الأقسام (Categories) */
            .categories-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }
            .category-card-new {
                padding: 15px !important;
            }
            .whatsapp-float { bottom: 80px; right: 20px; }
            
            /* تقليل البادينج العام للسكشن */
            section {
                padding: 30px 0 !important;
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

    <section class="new-arrivals featured-section" style="padding: 60px 0; background: #fff;">
        <div class="container">
            <h2 class="section-heading">المميزة</h2>
            <div class="products-grid">
                @foreach($featuredRooms as $room)
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

    <section class="categories-showcase container" style="padding: 80px 0;">
        <h2 class="section-heading" style="text-align: center; margin-bottom: 50px;">استكشف أقسامنا</h2>
        <div class="categories-grid">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="category-item">
                    <div class="category-card-new">
                        <div class="icon-box">
                            <i class="fas fa-couch"></i> 
                        </div>
                        <div class="category-info">
                            <h3>{{ $category->name }}</h3>
                            <span class="explore-text">استكشف الآن <i class="fas fa-arrow-left"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection