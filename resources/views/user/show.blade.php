@extends('layouts.master')

@section('title', $room->room_name ?? 'تفاصيل الغرفة')

@push('styles')
<style>
    /* 1. التخطيط العام */
    .product-page-main { margin-top: 30px; margin-bottom: 50px; }
    .product-info-wrapper { display: flex; gap: 40px; flex-wrap: wrap; align-items: start; }
    
    /* 2. معرض الصور */
    .image-gallery-section { flex: 1; min-width: 350px; }
    .main-image { width: 100%; border-radius: 15px; overflow: hidden; background: #fdfdfd; border: 1px solid #eee; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
    .main-image img { width: 100%; height: 500px; object-fit: cover; display: block; transition: 0.3s ease; }
    .image-slider { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; }
    .image-slider img { width: 85px; height: 85px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 2px solid transparent; transition: 0.3s; }
    .image-slider img.active { border-color: #C8A461; transform: scale(0.95); }

    /* 3. تفاصيل النص */
    .text-section { flex: 1; min-width: 350px; }
    .product-title { font-size: 2.2rem; font-weight: 800; color: #333; margin-bottom: 20px; }
    .price-section { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .price-main { font-size: 2rem; font-weight: 800; color: #C8A461; }
    .price-old { text-decoration: line-through; color: #999; font-size: 1.2rem; }
    .discount-tag { background: #e74c3c; color: #fff; padding: 4px 12px; border-radius: 50px; font-size: 0.9rem; font-weight: bold; }
    .product-details-text { line-height: 1.8; color: #666; font-size: 1.05rem; margin-bottom: 30px; }

    /* 4. التواصل والشراء */
    .whatsapp-cta { 
        display: flex; align-items: center; justify-content: center; gap: 12px; 
        background: #25D366; color: #fff; padding: 14px; border-radius: 10px; 
        text-decoration: none; font-weight: bold; margin-bottom: 20px; transition: 0.3s;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    }
    .whatsapp-cta:hover { background: #1eb954; transform: translateY(-2px); color: #fff; }

    /* 5. عداد الكمية المطور */
    .purchase-container { background: #f9f9f9; padding: 25px; border-radius: 15px; border: 1px solid #eee; }
    .purchase-wrapper { display: flex; align-items: flex-end; gap: 15px; }
    .qty-group { flex-shrink: 0; }
    .qty-stepper { 
        display: flex; align-items: center; background: #fff; border: 1px solid #ddd; 
        border-radius: 8px; height: 50px; width: 130px; overflow: hidden; 
    }
    .qty-stepper button { 
        width: 40px; height: 100%; border: none; background: #eee; 
        font-size: 1.3rem; cursor: pointer; transition: 0.2s; 
    }
    .qty-stepper button:hover { background: #e0e0e0; color: #C8A461; }
    .qty-stepper input { 
        width: 50px; border: none; text-align: center; font-weight: bold; 
        font-size: 1.1rem; outline: none; background: transparent; 
    }

    .add-to-cart-btn-new { 
        flex-grow: 1; height: 50px; background-color: #C8A461; color: white; border: none; 
        border-radius: 8px; font-weight: bold; font-size: 1.1rem; cursor: pointer; 
        transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .add-to-cart-btn-new:hover { background-color: #333; transform: translateY(-2px); }

    /* 6. التابات والجدول */
    .product-tabs-section { margin-top: 60px; }
    .tabs-nav { display: flex; gap: 30px; border-bottom: 2px solid #eee; margin-bottom: 25px; }
    .tab-button { padding: 12px 5px; cursor: pointer; font-weight: bold; color: #888; transition: 0.3s; position: relative; }
    .tab-button.active { color: #C8A461; }
    .tab-button.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 2px; background: #C8A461; }
    .tab-content { display: none; animation: fadeIn 0.4s; }
    .tab-content.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .specs-table { width: 100%; border-collapse: collapse; background: #fff; }
    .specs-table td { padding: 15px; border: 1px solid #eee; }
    .specs-table td:first-child { background: #fcfcfc; font-weight: bold; width: 180px; color: #444; }

    /* ----------------------------------------------------------- */
    /* التعديلات الجديدة للموبايل (تمت الإضافة ولم يتم الحذف) */
    /* ----------------------------------------------------------- */
    @media (max-width: 768px) {
        .product-info-wrapper { flex-direction: column; gap: 20px; }
        .main-image img { height: 280px !important; } /* تصغير الصورة لتناسب شاشة الموبايل بدلا من 500px */
        .image-slider img { width: 65px; height: 65px; } /* تصغير الصور المصغرة قليلا */
        
        .product-title { font-size: 1.5rem !important; margin-bottom: 10px !important; } /* تصغير العنوان الضخم */
        .price-main { font-size: 1.4rem !important; } /* تصغير السعر */
        .product-details-text { font-size: 0.95rem !important; margin-bottom: 20px !important; }
        
        /* جعل الكمية وزر السلة بجانب بعض بدلا من تحت بعض لتوفير مساحة */
        .purchase-wrapper { flex-direction: row !important; align-items: center; gap: 10px; }
        .qty-stepper { width: 110px !important; height: 45px !important; }
        .add-to-cart-btn-new { height: 45px !important; font-size: 1rem !important; }
        .qty-group label { margin-bottom: 5px !important; font-size: 0.8rem; }
        .purchase-container { padding: 15px !important; }

        .whatsapp-cta { padding: 10px !important; font-size: 0.9rem !important; }
        
        .product-tabs-section { margin-top: 30px; }
        .tabs-nav { gap: 15px; }
        .tab-button { font-size: 0.9rem; }
    }
</style>
@endpush

@section('content')
<main class="container product-page-main">
    <div class="product-info-wrapper">

        {{-- قسم الصور --}}
        <div class="image-gallery-section">
            <div class="main-image">
                <img id="mainRoomImage" src="{{ $room->image_url ?? asset('images/no-image.jpg') }}" alt="{{ $room->room_name }}">
            </div>

            <div class="image-slider">
                @if($room->images && $room->images->count())
                    @foreach($room->images as $index => $image)
                        <img src="{{ asset('images/uploads/' . ltrim($image->image_path, '/')) }}"
                             onclick="updateActiveThumbnail(this)"
                             alt="صورة {{ $index + 1 }}"
                             class="{{ $index === 0 ? 'active' : '' }}">
                    @endforeach
                @endif
            </div>
        </div>

        {{-- قسم التفاصيل --}}
        <div class="text-section">
            <h1 class="product-title">{{ $room->room_name }}</h1>

            <div class="price-section">
                <span class="price-main">{{ $room->formatted_price }} ج.م</span>
                @if($room->is_discounted)
                    <span class="price-old">{{ $room->old_price }}</span>
                    <span class="discount-tag">خصم {{ $room->discount_percent }}%</span>
                @endif
            </div>

            <p class="product-details-text">{{ $room->description }}</p>

            <a href="https://wa.me/+201000408109" target="_blank" class="whatsapp-cta">
                <i class="fab fa-whatsapp"></i> تواصل معنا
            </a>

            {{-- فورم الشراء والكمية --}}
            <form action="{{ route('cart.add') }}" method="POST" class="purchase-container">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                
                <div class="purchase-wrapper">
                    <div class="qty-group">
                        <label for="qty" class="fw-bold mb-2 d-block small">الكمية</label>
                        <div class="qty-stepper">
                            <button type="button" onclick="changeQuantity(-1)">−</button>
                            <input type="number" name="qty" id="qty" value="1" min="1" readonly>
                            <button type="button" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>

                    <button type="submit" class="add-to-cart-btn-new">
                        <i class="fas fa-shopping-basket"></i> أضف إلى السلة
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- التابات للمواصفات --}}
    
</main>
@endsection

@push('scripts')
<script>
// 1. تغيير الصورة الرئيسية
function updateActiveThumbnail(clickedImg) {
    document.querySelectorAll('.image-slider img').forEach(img => img.classList.remove('active'));
    clickedImg.classList.add('active');
    const mainImg = document.getElementById('mainRoomImage');
    mainImg.style.opacity = '0.7';
    setTimeout(() => {
        mainImg.src = clickedImg.src;
        mainImg.style.opacity = '1';
    }, 100);
}

// 2. التحكم في عداد الكمية
function changeQuantity(change) {
    const qtyInput = document.getElementById('qty');
    let currentVal = parseInt(qtyInput.value) || 1;
    let newVal = currentVal + change;
    if (newVal >= 1) qtyInput.value = newVal;
}

// 3. تبديل التابات
function switchTab(event, tabId) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active');
}
</script>
@endpush