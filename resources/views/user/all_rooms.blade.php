@extends('layouts.master')

@section('title', 'زاد للأثاث | المعرض')

@section('content')

<div class="page-wrapper">

    <aside class="sidebar">
        <form action="{{ url()->current() }}" method="GET">

            <div class="filter-group">
                <div class="filter-title">ترتيب حسب</div>
                <select name="sort" class="filter-select">
                    <option value="latest" @selected(($filters['sort'] ?? '') === 'latest')>الأحدث أولاً</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>السعر من الأقل</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>السعر من الأعلى</option>
                </select>
            </div>

            <div class="filter-group">
                <div class="filter-title">الأقسام</div>
                <ul class="filter-options">
                    @foreach($categories as $category)
                        <li>
                            <label>
                                <input
                                    type="checkbox"
                                    name="category[]"
                                    value="{{ $category->id }}"
                                    @checked(in_array($category->id, $filters['category'] ?? []))
                                >
                                {{ $category->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-group">
                <div class="filter-title">تصفية سريعة</div>
                <ul class="filter-options">
                    <li>
                        <label>
                            <input type="checkbox" name="is_featured" value="1" @checked($filters['is_featured'] ?? false)>
                            منتجات مميزة
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="has_discount" value="1" @checked($filters['has_discount'] ?? false)>
                            عليه خصومات
                        </label>
                    </li>
                </ul>
            </div>

            <button class="btn-filter">تطبيق</button>
        </form>
    </aside>

    <main class="content-area">

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

    </main>
</div>
@endsection
