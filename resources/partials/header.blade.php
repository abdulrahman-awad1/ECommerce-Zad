<header class="main-header">
    <div class="header-content container">
        <div class="logo">زاد <span style="color: var(--color-dark)">للأثاث</span></div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('sections') }}">الأقسام</a></li>
                <li><a href="#">العروض</a></li>
                <li><a href="{{ route('contact') }}">التواصل</a></li>
            </ul>
        </nav>
        
        <div class="header-icons">
            <i class="fas fa-search"></i>
            
            @guest
                {{-- يظهر هذا الزر فقط إذا لم يكن المستخدم مسجلاً دخوله --}}
                <button id="auth-btn" class="cta-btn" style="padding: 5px 15px; font-size: 0.9em; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-user-circle" style="color: var(--color-white);"></i> دخول / تسجيل
                </button>
            @else
                {{-- يظهر اسم المستخدم أو لوحة التحكم إذا كان مسجلاً دخوله --}}
                <div class="user-menu" style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.9em;">مرحباً، {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: red; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @endguest

            <i class="fas fa-shopping-bag"></i>
        </div>
    </div>
</header>