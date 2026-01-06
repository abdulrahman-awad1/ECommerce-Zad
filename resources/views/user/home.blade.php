@extends('layouts.master')

@section('title', 'الرئيسية')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
    </section>


    <section class="categories-showcase container" style="padding: 80px 0;">
    <h2 class="section-heading" style="text-align: center; margin-bottom: 50px;">استكشف أقسامنا</h2>
    
    <div class="categories-grid">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->id) }}" class="category-item">
                <div class="category-card-new">
                    <div class="icon-box">
                        <i class="fas fa-couch"></i> </div>
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