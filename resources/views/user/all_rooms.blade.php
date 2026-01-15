@extends('layouts.master')

@section('title', 'زاد للأثاث | المعرض')

@section('content')

<style>
    /* الحاوية الرئيسية */
    .page-wrapper { 
        display: flex; 
        gap: 20px; 
        margin: 30px auto; 
        max-width: 1400px; 
        padding: 0 15px; 
        font-family: 'Cairo', sans-serif;
    }

    /* --- تحسين الـ Sidebar --- */
    .sidebar { 
        width: 240px; 
        flex-shrink: 0; 
        background: #fcfcfc; 
        border: 1px solid #f0f0f0; 
        padding: 20px; 
        border-radius: 12px; 
        position: sticky; 
        top: 20px; 
        align-self: flex-start;
    }
    .filter-group { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0; }
    .filter-group:last-child { border: none; }
    
    .filter-title { 
        font-weight: 700; 
        margin-bottom: 12px; 
        color: #444; 
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* القائمة الافتراضية للكمبيوتر */
    .filter-options { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .filter-options label { cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #666; }
    .filter-options input[type="checkbox"] { width: 16px; height: 16px; accent-color: #c8a461; }
    
    .filter-select { 
        width: 100%; 
        padding: 8px; 
        border-radius: 6px; 
        border: 1px solid #ddd; 
        font-size: 0.85rem;
    }
    .btn-filter { 
        width: 100%; 
        padding: 10px; 
        background: #c8a461; 
        border: none; 
        color: #fff; 
        border-radius: 6px; 
        cursor: pointer; 
        font-weight: bold; 
    }

    /* --- منطقة المنتجات --- */
    .content-area { flex-grow: 1; }
    .products-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
        gap: 15px; 
    }
    
    .room-card { 
        background: #fff; 
        border-radius: 10px; 
        border: 1px solid #efefef; 
        overflow: hidden; 
        transition: 0.3s; 
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    .image-wrapper { position: relative; height: 180px; }
    .image-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .card-body { padding: 12px; flex-grow: 1; text-align: right; }
    .room-name { font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 5px; color: #333; }
    .room-desc { font-size: 0.75rem; color: #888; height: 35px; overflow: hidden; line-height: 1.4; }
    
    .price-row { margin: 10px 0; }
    .price-main { font-weight: 800; color: #c8a461; font-size: 1rem; }

    .add-to-cart-btn {
        width: 100%; border: 1px solid #c8a461; padding: 8px; border-radius: 5px; 
        background: transparent; color: #c8a461; font-weight: bold; font-size: 0.8rem;
    }

    /* --- تعديلات الجوال --- */
    @media (max-width: 992px) {
        .page-wrapper { flex-direction: column; }
        .sidebar { width: 100%; position: relative; top: 0; padding: 15px; }
        
        /* جعل عناصر التصفية تظهر بجانب بعضها لتقليل الطول */
        .filter-options { 
            display: grid; 
            grid-template-columns: 1fr 1fr; /* عمودين بجانب بعض */
            gap: 12px;
        }

        .sidebar form { display: grid; grid-template-columns: 1fr; gap: 10px; }
    }

    @media (max-width: 576px) {
        .products-grid { 
            grid-template-columns: 1fr 1fr; /* منتجين في الصف */
            gap: 10px; 
        }
        .image-wrapper { height: 140px; }
        .room-desc { display: none; }
    }
</style>

<div class="page-wrapper">

    {{-- القائمة الجانبية --}}
    <aside class="sidebar">
        <form action="{{ url()->current() }}" method="GET">
            {{-- الترتيب --}}
            <div class="filter-group">
                <div class="filter-title"><i class="fas fa-sort-amount-down"></i> ترتيب حسب</div>
                <select name="sort" class="filter-select">
                    <option value="latest" @selected(($filters['sort'] ?? '') === 'latest')>الأحدث أولاً</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>السعر: الأقل</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>السعر: الأعلى</option>
                </select>
            </div>

            {{-- الأقسام - الآن تظهر بجانب بعض في الجوال --}}
            <div class="filter-group">
                <div class="filter-title"><i class="fas fa-th-list"></i> الأقسام</div>
                <ul class="filter-options">
                    @foreach($categories as $category)
                        <li>
                            <label>
                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                    @checked(in_array($category->id, $filters['category'] ?? []))>
                                {{ $category->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- تصفية سريعة - تظهر بجانب بعض أيضاً --}}
            <div class="filter-group">
                <div class="filter-title"><i class="fas fa-bolt"></i> تصفية سريعة</div>
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
                            عروض وخصومات
                        </label>
                    </li>
                </ul>
            </div>
            
            <button type="submit" class="btn-filter">تطبيق الفلاتر</button>
        </form>
    </aside>

    {{-- منطقة المنتجات --}}
    <main class="content-area">
        <div class="products-grid">
            @foreach($rooms as $room)
                <div class="room-card">
                    <a href="{{ route('show_room', $room->id) }}" style="text-decoration: none; color: inherit; flex-grow: 1;">
                        <div class="image-wrapper">
                            @if($room->is_featured) <div class="featured-tag">مميز</div> @endif
                            @if($room->is_discounted) <div class="discount-tag">خصم {{ $room->discount_percent }}%</div> @endif
                            <img src="{{ $room->image_url }}" alt="{{ $room->room_name }}">
                        </div>
                        <div class="card-body">
                            <span class="room-name">{{ $room->room_name }}</span>
                            <p class="room-desc">{{ $room->description }}</p>
                            <div class="price-row">
                                <span class="price-main">{{ $room->formatted_price }} ج.م</span>
                            </div>
                        </div>
                    </a>
                    <div style="padding: 0 10px 10px;">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <button type="submit" class="cta-btn" style="padding: 10px 20px; font-size: 0.9em; border: none; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-shopping-basket"></i> أضف للعربة
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>

@endsection