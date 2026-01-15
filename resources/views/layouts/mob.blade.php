<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'زاد للأثاث')</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    
    <style>
        /* تنسيقات الموبايل الأساسية */
        body { padding-top: 60px; padding-bottom: 70px; background: #f9f9f9; }
        
        .mobile-header {
            position: fixed; top: 0; left: 0; right: 0; height: 60px;
            background: #fff; display: flex; align-items: center; justify-content: space-between;
            padding: 0 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 1000;
        }

        .m-logo img { height: 35px; }
        .m-logo-text { font-weight: bold; font-size: 1.1rem; color: var(--color-primary); }

        /* القائمة السفلية */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; background: #fff;
            display: flex; justify-content: space-around; padding: 10px 0;
            border-top: 1px solid #eee; z-index: 1000;
        }
        .nav-item { text-align: center; color: #555; text-decoration: none; font-size: 0.8rem; position: relative; }
        .nav-item i { display: block; font-size: 1.4rem; margin-bottom: 2px; }
        .nav-item .badge {
            position: absolute; top: -5px; right: -5px; background: #e74c3c;
            color: #fff; border-radius: 50%; padding: 2px 6px; font-size: 10px;
        }

        /* تعديلات السيرش والمودال للموبايل */
        #searchOverlay { padding-top: 20px; }
        .modal-content { width: 90% !important; margin: 20px auto; }
        .footer-grid { padding: 20px; text-align: center !important; }
        .whatsapp-float { bottom: 80px; right: 20px; }
    </style>


    @stack('styles')
</head>
<body>
<div id="sideCartMobile" style="position: fixed; top: 0; left: -100%; width: 300px; height: 100%; background: #fff; z-index: 4000; transition: 0.3s; box-shadow: 5px 0 15px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
    <div style="padding: 20px; background: #f8f9fa; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
        <i class="fas fa-shopping-bag" onclick="toggleSideCart()" style="font-size: 1.2rem; cursor: pointer; color: #666;"></i>
        <span style="font-weight: bold; color: #b08d57;">سلة المشتريات</span>
    </div>

    <div style="flex: 1; overflow-y: auto; padding: 15px;">
        @if($cartItems->isEmpty())
            <div style="text-align: center; margin-top: 50px; color: #ccc;">
                <i class="fas fa-shopping-basket" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p>السلة فارغة حالياً</p>
            </div>
        @else
            @foreach($cartItems as $item)
                <div style="display: flex; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid #f5f5f5; padding-bottom: 10px;">
                    <img src="{{ $item->room->images->first() ? asset('images/uploads/' . $item->room->images->first()->image_path) : asset('images/no-image.jpg') }}" 
                         style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                    <div style="flex: 1;">
                        <h4 style="font-size: 0.85rem; margin: 0;">{{ $item->room->room_name }}</h4>
                        <span style="font-size: 0.8rem; color: #777;">{{ $item->quantity }} × {{ number_format($item->room->price) }} ج.م</span>
                    </div>
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $item->id }}">
                        <button type="submit" style="background: none; border: none; color: #e74c3c;"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>

    @if(!$cartItems->isEmpty())
        <div style="padding: 20px; border-top: 1px solid #eee; background: #fff;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: bold;">
                <span>الإجمالي:</span>
                <span>{{ number_format($cartTotal) }} ج.م</span>
            </div>
            <a href="{{ route('checkout.index') }}" style="display: block; background: #b08d57; color: #fff; text-align: center; padding: 12px; border-radius: 5px; text-decoration: none;">إتمام الطلب</a>
        </div>
    @endif
</div>

<div id="sideCartOverlay" onclick="toggleSideCart()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3999;"></div>

<div id="sideMenuMobile" style="position: fixed; top: 0; right: -100%; width: 280px; height: 100%; background: #fff; z-index: 4000; transition: 0.3s; box-shadow: -5px 0 15px rgba(0,0,0,0.1);">
    <div style="padding: 20px; background: #f8f9fa; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
        <span style="font-weight: bold; color: #b08d57;">القائمة</span>
        <i class="fas fa-times" onclick="toggleSideMenu()" style="font-size: 1.2rem; cursor: pointer; color: #666;"></i>
    </div>
    
    <nav style="padding: 10px 0;">
        <a href="{{ route('home') }}" style="display: block; padding: 15px 20px; text-decoration: none; color: #333; border-bottom: 1px solid #f9f9f9;"><i class="fas fa-home" style="margin-left: 10px; color: #b08d57;"></i> الرئيسية</a>
        <a href="{{ route('sections') }}" style="display: block; padding: 15px 20px; text-decoration: none; color: #333; border-bottom: 1px solid #f9f9f9;"><i class="fas fa-th-large" style="margin-left: 10px; color: #b08d57;"></i> الأقسام</a>
        @auth
            <a href="{{ route('user.orders') }}" style="display: block; padding: 15px 20px; text-decoration: none; color: #333; border-bottom: 1px solid #f9f9f9;"><i class="fas fa-box-open" style="margin-left: 10px; color: #b08d57;"></i> طلباتي</a>
        @endauth
        <a href="{{ route('contact') }}" style="display: block; padding: 15px 20px; text-decoration: none; color: #333; border-bottom: 1px solid #f9f9f9;"><i class="fas fa-envelope" style="margin-left: 10px; color: #b08d57;"></i> تواصل معنا</a>
        
        @guest
            <a href="#" onclick="toggleSideMenu(); document.getElementById('auth-btn').click();" style="display: block; padding: 15px 20px; text-decoration: none; color: #333;"><i class="fas fa-sign-in-alt" style="margin-left: 10px; color: #b08d57;"></i> تسجيل الدخول</a>
        @endguest

        @auth
             <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">@csrf</form>
             <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display: block; padding: 15px 20px; text-decoration: none; color: #333;"><i class="fas fa-sign-in-alt" style="margin-left: 10px; color: #e74c3c;"></i> خروج</a>

           
        @endauth
    </nav>
</div>

<div id="sideMenuOverlay" onclick="toggleSideMenu()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3999;"></div>

<header class="mobile-header" style="display: flex; align-items: center; justify-content: space-between; padding: 0 15px; height: 60px; background: #fff; position: fixed; top: 0; width: 100%; z-index: 1000; box-shadow: 0 2px 5px rgba(0,0,0,0.05); overflow: visible;">
    
    <div style="flex: 1; display: flex; align-items: center; gap: 15px;">
        <i class="fas fa-bars" onclick="toggleSideMenu()" style="font-size: 1.2rem; color: #333; cursor: pointer;"></i>
        <i class="fas fa-search" onclick="document.getElementById('searchOverlay').style.display='block'" style="font-size: 1.1rem; color: #333; cursor: pointer;"></i>
    </div>

    <div style="flex: 2; display: flex; justify-content: center; align-items: center;">
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 6px; text-decoration: none; color: inherit;">
            <img src="{{ asset('images/logo.jpg') }}" alt="لوجو" style="height: 30px; width: auto; border-radius: 4px;">
            <span style="font-weight: bold; font-size: 1rem; color: #b08d57; white-space: nowrap;">زاد <span style="color: #333">للأثاث</span></span>
        </a>
    </div>

    <div style="flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 12px; position: relative;">
        
        @auth
        <div class="notifications-wrapper" style="position: static;"> 
            <i class="far fa-bell" id="notifBtnMobile" style="font-size: 1.2rem; cursor: pointer; padding: 5px; display: block;"></i>
            
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span style="position: absolute; top: 5px; left: 40px; background: red; color: #fff; border-radius: 50%; padding: 1px 5px; font-size: 9px; pointer-events: none; z-index: 1001;">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif

            <div id="notifDropdownMobile" style="display: none; position: absolute; top: 60px; left: 0; width: 280px; background: #fff; border: 1px solid #eee; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-radius: 10px; z-index: 5000; overflow: hidden;">
                <div style="padding: 10px; background: #f8f9fa; border-bottom: 1px solid #eee; font-weight: bold; font-size: 0.9rem;">التنبيهات</div>
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                    <a href="{{ route('notifications.read', $notification->id) }}" >
                        <div style="padding: 12px; border-bottom: 1px solid #f9f9f9; font-size: 0.85rem;">
                            {{ $notification->data['message'] ?? 'تنبيك جديد' }}
                        </div>
                        </a>
                    @empty
                        <div style="padding: 20px; text-align: center; color: #999; font-size: 0.85rem;">لا توجد تنبيهات جديدة</div>
                    @endforelse
                </div>
            </div>
        </div>
        @endauth

        <div style="position: relative; cursor: pointer;" onclick="toggleSideCart()">
            <i class="fas fa-shopping-bag" style="font-size: 1.2rem; color: #333;"></i>
            @if(isset($cartCount) && $cartCount > 0)
                <span class="badge cart-count" style="position: absolute; top: -8px; right: -8px; background: #b08d57; color: #fff; border-radius: 50%; padding: 1px 5px; font-size: 9px;">{{ $cartCount }}</span>
            @endif
        </div>
    </div>
</header>

    <nav class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item">
            <i class="fas fa-home"></i> الرئيسية
        </a>
       
        <a href="{{ route('cart.index') }}" class="nav-item">
            <i class="fas fa-shopping-bag"></i>
            <span class="badge cart-count">{{ $cartCount }}</span> السلة
        </a>
        @guest
            <a href="#" id="auth-btn" class="nav-item">
                <i class="fas fa-user-circle"></i> حسابي
            </a>
        @endguest
        @auth
            <a href="{{ route('user.orders') }}" class="nav-item">
                <i class="fas fa-user-circle"></i> حسابي
            </a>
           
        @endauth
    </nav>

    <div id="searchOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #ffffff; z-index: 3000; overflow-y: auto; animation: fadeIn 0.3s ease-in-out;">
    <div style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #f0f0f0; gap: 10px; position: sticky; top: 0; background: #fff; z-index: 10;">
        <i class="fas fa-chevron-right" onclick="closeSearch()" style="font-size: 1.2rem; color: #666; padding: 5px;"></i>
        <div style="flex: 1; position: relative;">
            <input type="text" id="searchInputMobile" placeholder="ابحث عن غرف، أثاث..." 
                   style="width: 100%; padding: 12px 40px 12px 15px; border: 1px solid #eee; border-radius: 25px; background: #f8f8f8; font-family: 'Cairo'; outline: none; font-size: 0.95rem;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
        </div>
    </div>

    <div class="container" style="padding: 20px;">
        <div id="searchResultsGridMobile" class="results-grid">
            <div style="text-align: center; color: #ccc; margin-top: 50px;">
                <i class="fas fa-search" style="font-size: 3rem; opacity: 0.2; display: block; margin-bottom: 10px;"></i>
                <p>ابدأ بالكتابة للبحث عن المنتجات</p>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
/* تنسيق شبكة النتائج للموبايل */
.results-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
</style>

@if(session('success'))
    <div class="custom-alert success-alert" id="successAlert" style="position: fixed; top: 70px; left: 10px; right: 10px; z-index: 1001;">
        <div class="alert-content">
            <div class="alert-text"><span>{{ session('success') }}</span></div>
        </div>
    </div>
    
@endif

    <main>
        @yield('content')
    </main>

    <footer class="main-footer" style="background: #333; color: #fff; padding: 30px 15px; text-align: center;">
        <div class="footer-about">
            <h3 style="color: var(--color-primary);">زاد للأثاث</h3>
            <p style="font-size: 0.9em; color: #ccc;">وجهتكم الأولى للأثاث الراقي.</p>
        </div>
        <div style="margin: 20px 0; display: flex; justify-content: center; gap: 20px;">
            <a href="{{route('contact')}}" style="color: #fff; text-decoration: none;">تواصل معنا</a>
            <a href="https://wa.me/201019494330" style="color: #25d366; text-decoration: none;"><i class="fab fa-whatsapp"></i> واتساب</a>
        </div>
        <p style="font-size: 0.8em; color: #888;">&copy; 2025 جميع الحقوق محفوظة.</p>
    </footer>

    <div id="auth-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header"><h3>تسجيل الدخول</h3></div>
            @if ($errors->any())
                <div class="auth-errors-alert" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85em;">
                    <ul style="margin: 0; padding-right: 20px;">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            <div class="tab-buttons">
                <button id="login-tab-btn" class="active">تسجيل الدخول</button>
                <button id="register-tab-btn">تسجيل جديد</button>
            </div>
            <form id="login-form" class="auth-form" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="auth-form-group"><label>البريد الإلكتروني</label><input type="email" name="email" required></div>
                <div class="auth-form-group"><label>كلمة المرور</label><input type="password" name="password" required></div>
                <button type="submit" class="cta-btn" style="width: 100%;">دخول</button>
            </form>
            <form id="register-form" class="auth-form" action="{{ route('register') }}" method="POST" style="display: none;">
                @csrf
                <div class="auth-form-group"><label>الاسم</label><input type="text" name="name" required></div>
                <div class="auth-form-group"><label>الإيميل</label><input type="email" name="email" required></div>
                <div class="auth-form-group"><label>كلمة المرور</label><input type="password" name="password" required></div>
                <div class="auth-form-group"><label>تأكيد المرور</label><input type="password" name="password_confirmation" required></div>
                <button type="submit" class="cta-btn" style="width: 100%;">تسجيل</button>
            </form>
        </div>
    </div>

    <a href="https://wa.me/201019494330" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

    <script src="{{ asset('js/auth-modal.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/mob.js') }}"></script>

    @stack('scripts')

    <script>
        // لضمان عمل المودال عند وجود أخطاء
        document.addEventListener('DOMContentLoaded', function() {
    @if ($errors->any())
        const modal = document.getElementById('auth-modal');
        if (modal) { modal.style.display = 'flex'; modal.classList.add('active'); }
    @endif
});
       
    </script>
</body>
</html>