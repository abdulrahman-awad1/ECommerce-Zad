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
        /* تنسيقات إضافية للإشعارات */
        .notifications-wrapper { position: relative; margin-left: 15px; }
        .notif-btn { background: none; border: none; font-size: 1.4rem; color: var(--color-primary); cursor: pointer; position: relative; }
        .notif-count { position: absolute; top: -5px; right: -8px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 6px; border-radius: 50%; border: 2px solid #white; }
        
        .notif-dropdown { 
            position: absolute; top: 45px; left: 0; width: 280px; background: white; 
            border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            display: none; z-index: 1000; border: 1px solid #eee; overflow: hidden;
        }
        .notifications-wrapper:hover .notif-dropdown { display: block; }
        
        .notif-header { padding: 10px 15px; background: #f9f9f9; border-bottom: 1px solid #eee; font-weight: bold; font-size: 0.9em; }
        .notif-item { padding: 12px 15px; border-bottom: 1px solid #f1f1f1; display: block; text-decoration: none; color: #333; transition: 0.3s; }
        .notif-item:hover { background: #fcfaf5; }
        .notif-item p { margin: 0; font-size: 0.85em; line-height: 1.4; }
        .notif-item small { color: #999; font-size: 0.75em; display: block; margin-top: 5px; }
        .empty-notif { padding: 20px; text-align: center; color: #bbb; font-size: 0.9em; }
    </style>

    @stack('styles')
</head>
<body>

    <header class="main-header">
        <div class="header-content container">
        <div class="logo">
    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
        <img src="{{ asset('images/logo.jpg') }}" alt="لوجو زاد للأثاث" class="logo-img">
        
        <div class="logo-text">
            زاد <span style="color: var(--color-dark)">للأثاث</span>
        </div>
    </a>
</div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="{{route('home')}}">الرئيسية</a></li>
                    <li><a href="{{route('sections')}}"> الأقسام</a></li>
                    <li><a href="{{route('contact')}}">التواصل</a></li>
                </ul>
            </nav>

            <div class="header-icons">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="ابحث عن غرفة..." autocomplete="off">
                </div>
                
                @auth
<div class="notifications-wrapper" id="notifWrapper">
    <button type="button" class="notif-btn" id="notifBtn">
        <i class="far fa-bell"></i>
        @php $uCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($uCount > 0)
            <span class="notif-count">{{ $uCount }}</span>
        @endif
    </button>
    
    <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-header">
            <span>التنبيهات</span>
            @if($uCount > 0)
                <a href="{{ route('notifications.markAllRead') }}" class="mark-all">تحديد الكل كمقروء</a>
            @endif
        </div>
        <div class="notif-list">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}" class="notif-item">
                
                    <div class="notif-icon-circle">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="notif-content-text">
                        <p>{{ $notification->data['message'] }}</p>
                        <small><i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </a>
                <a href="{{route('contact')}}">التواصل</a>
            @empty
                <div class="empty-notif">لا توجد تنبيهات جديدة</div>
            @endforelse
          
            
        </div>
    </div>
</div>
<div class="header-icons">
    <a href="{{ route('user.orders') }}" class="icon-link orders-link" title="طلباتي">
        <i class="fas fa-box-open"></i> <span class="icon-label">طلباتي</span>
    </a>
</div>
@endauth

                <div class="cart-wrapper">
                    <button id="cartToggle" class="cart-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count">{{ $cartCount }}</span>
                    </button>

                    <div id="cartDropdown" class="cart-dropdown">
                        @if($cartItems->isEmpty())
                            <div class="empty-cart-wrapper">
                                <i class="fas fa-shopping-basket"></i>
                                <p>السلة فارغة حالياً</p>
                            </div>
                        @else
                            <div class="cart-items-container">
                                @foreach($cartItems as $item)
                                    <div class="cart-item" id="cart-item-{{ $item->id }}">
                                        <div class="cart-item-img">
                                        <img src="{{ $item->room->images->first()->image_path
    ? asset('images/uploads/' . $item->room->images->first()->image_path)
    : asset('images/no-image.jpg') }}">

                                        </div>
                                        <div class="cart-item-info">
                                            <strong>{{ $item->room->room_name }}</strong>
                                            <div class="cart-item-details">
                                                <span class="qty">{{ $item->quantity }} ×</span>
                                                <span class="price">{{ number_format($item->room->price) }} ج.م</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.remove') }}" method="POST" class="remove-item-form">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                            <button type="submit" class="remove-btn-icon" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cart-footer">
                                <div class="cart-total">
                                    <span>الإجمالي:</span>
                                    <span class="total-amount">{{ number_format($cartTotal) }} ج.م</span>
                                </div>
                                <div class="cart-actions">
                                    <a href="{{ route('cart.index') }}" class="btn-view-cart">السلة</a>
                                    <a href="{{ route('checkout.index') }}" class="btn-checkout-head">إتمام الطلب</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @guest
                    <button id="auth-btn" class="cta-btn" style="padding: 5px 15px; font-size: 0.9em; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-user-circle"></i> دخول
                    </button>
                @endguest

                @auth
                    <div class="user-menu-wrapper" style="display: flex; align-items: center; gap: 15px;">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout-btn" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 0.9em; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-sign-out-alt"></i> خروج
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <div id="searchOverlay">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>نتائج البحث</h2>
                <span onclick="closeSearch()" style="cursor: pointer; color: #999;"><i class="fas fa-times"></i> إغلاق</span>
            </div>
            <div id="searchResultsGrid" class="results-grid"></div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="custom-alert success-alert" id="successAlert">
        <div class="alert-content">
            <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
            <div class="alert-text"><span>{{ session('success') }}</span></div>
            <button class="close-alert" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
        </div>
        <div class="progress-bar"></div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="main-footer">
    <div class="container">
        <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; text-align: right; padding-bottom: 30px;">
            
            <div class="footer-about">
                <h3 style="color: var(--color-primary); margin-bottom: 15px;">زاد للأثاث</h3>
                <p style="line-height: 1.6; color: #ccc;">وجهتكم الأولى للأثاث الراقي والفرادنيات المتميزة. نجمع بين الجودة العالية والتصاميم العصرية لتأثيث منزل أحلامكم.</p>
            </div>

            <div class="footer-links">
                <h3 style="margin-bottom: 15px;">روابط سريعة</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;"><a href="{{route('home')}}" style="color: #ccc; text-decoration: none;">الرئيسية</a></li>
                    <li style="margin-bottom: 8px;"><a href="{{route('sections')}}" style="color: #ccc; text-decoration: none;">الأقسام</a></li>
                    <li style="margin-bottom: 8px;"><a href="{{route('contact')}}" style="color: #ccc; text-decoration: none;">تواصل معنا</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h3 style="margin-bottom: 15px;">تواصل معنا</h3>
                <p style="color: #ccc; margin-bottom: 8px;"><i class="fas fa-map-marker-alt" style="margin-left: 10px;"></i> عزب النهضه ، دمياط</p>
                <p style="color: #ccc; margin-bottom: 8px;"><i class="fas fa-phone" style="margin-left: 10px;"></i> 01019494330</p>
                <p style="color: #ccc;"><i class="fab fa-whatsapp" style="margin-left: 10px;"></i> تواصل عبر الواتساب</p>
            </div>

        </div>

        <hr style="border: 0; border-top: 1px solid #333; margin-bottom: 20px;">

        <div class="footer-bottom" style="text-align: center; color: #888; font-size: 0.9em;">
            <p>&copy; 2025 زاد للأثاث. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>

    <div id="auth-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header"><h3>تسجيل الدخول</h3></div>

        {{-- إضافة عرض الأخطاء هنا --}}
        @if ($errors->any())
            <div class="auth-errors-alert" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85em;">
                <ul style="margin: 0; padding-right: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="tab-buttons">
            <button id="login-tab-btn" class="active">تسجيل الدخول</button>
            <button id="register-tab-btn">تسجيل جديد</button>
        </div>

        {{-- نموذج الدخول --}}
        <form id="login-form" class="auth-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="auth-form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="auth-form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="cta-btn" style="width: 100%;">دخول</button>
        </form>

        {{-- نموذج التسجيل --}}
        <form id="register-form" class="auth-form" action="{{ route('register') }}" method="POST" style="display: none;">
            @csrf
            <div class="auth-form-group"><label>الاسم</label><input type="text" name="name" value="{{ old('name') }}" required></div>
            <div class="auth-form-group"><label>الإيميل</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            <div class="auth-form-group"><label>كلمة المرور</label><input type="password" name="password" required></div>
            <div class="auth-form-group"><label>تأكيد المرور</label><input type="password" name="password_confirmation" required></div>
            <button type="submit" class="cta-btn" style="width: 100%;">تسجيل</button>
        </form>
    </div>
</div>
    <a href="https://wa.me/201234567890" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="تواصل معنا عبر واتساب">
    <i class="fab fa-whatsapp"></i>
</a>

    <script src="{{ asset('js/auth-modal.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // إذا كان هناك أخطاء في الجلسة، قم بفتح المودال تلقائياً
        @if ($errors->any())
            const modal = document.getElementById('auth-modal');
            if (modal) {
                modal.classList.add('active'); // أو الطريقة التي تستخدمها لإظهار المودال في CSS
                modal.style.display = 'flex'; 
            }
        @endif
    });
</script>
</body>
</html>