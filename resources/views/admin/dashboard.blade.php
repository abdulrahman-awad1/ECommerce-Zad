<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة | زاد للأثاث</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --color-primary: #34495e; 
            --color-secondary: #C8A461; 
            --color-light-bg: #f8f9fa; 
            --color-sidebar-bg: #2c3e50; 
            --color-white: #ffffff;
            --font-main: 'Cairo', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--color-light-bg);
            direction: rtl;
            text-align: right;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        /* 1. القائمة الجانبية (Sidebar) */
        .sidebar {
            width: 260px;
            background-color: var(--color-sidebar-bg);
            color: var(--color-white);
            padding: 20px 0;
            position: fixed;
            height: 100%;
            z-index: 1001;
        }

        .logo {
            text-align: center;
            padding: 0 20px 40px;
            font-size: 1.6em;
            font-weight: 700;
            color: var(--color-secondary);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            transition: 0.3s;
            border-right: 4px solid transparent;
            margin-bottom: 5px;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255,255,255,0.05);
            color: var(--color-white);
            border-right-color: var(--color-secondary);
        }

        .nav-link i { margin-left: 15px; width: 20px; font-size: 1.1em; }
        
        .logout-btn {
            background-color: #e74c3c;
            color: var(--color-white);
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 85%;
            margin: 40px auto 0;
            display: block;
            border-radius: 8px;
            font-family: 'Cairo';
            font-weight: 700;
            transition: 0.3s;
        }
        .logout-btn:hover { background-color: #c0392b; }

        /* 2. المحتوى الرئيسي */
        .main-content {
            margin-right: 260px;
            flex-grow: 1;
            padding: 30px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .welcome-msg { font-size: 1.5em; color: var(--color-primary); font-weight: 700; margin: 0; }
        .welcome-msg span { color: var(--color-secondary); }

        /* 3. نظام الإشعارات */
        .notifications-wrapper {
            position: relative;
            cursor: pointer;
        }

        .bell-icon {
            font-size: 1.4em;
            color: var(--color-primary);
            padding: 10px;
            background: #f4f7f6;
            border-radius: 50%;
            transition: 0.3s;
        }

        .notifications-wrapper:hover .bell-icon { background: #eee; }

        .unread-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border: 2px solid white;
        }

        .notifications-dropdown {
            position: absolute;
            top: 50px;
            left: 0;
            width: 320px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            display: none;
            z-index: 2000;
            border: 1px solid #eee;
            overflow: hidden;
        }

        .notifications-wrapper:hover .notifications-dropdown { display: block; }

        .dropdown-header {
            padding: 15px;
            background: #fcfaf5;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            font-size: 0.9em;
            display: flex;
            justify-content: space-between;
        }

        .notification-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
            transition: 0.2s;
        }

        .notification-item:hover { background: #f9f9f9; }

        .notif-icon {
            background: #f39c1222;
            color: #d35400;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 12px;
        }

        .notif-body b { display: block; font-size: 0.9em; color: #333; margin-bottom: 4px; }
        .notif-body small { color: #999; font-size: 0.8em; }

        .no-notif { padding: 30px; text-align: center; color: #bbb; }

        /* 4. الإحصائيات */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .stat-card {
            background-color: var(--color-white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); }

        .stat-icon-box {
            width: 60px;
            height: 60px;
            background: #fdfaf4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
        }

        .stat-icon-box i { font-size: 1.8em; color: var(--color-secondary); }

        .stat-info h3 { font-size: 1.8em; margin: 0; color: var(--color-primary); }
        .stat-info p { margin: 5px 0 0; color: #7f8c8d; font-size: 0.95em; }

        .action-btn {
            background: var(--color-secondary);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
            transition: 0.3s;
        }
        .action-btn:hover { background: var(--color-primary); }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar .logo, .sidebar span, .sidebar .nav-link span { display: none; }
            .main-content { margin-right: 70px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">زاد <span>للأثاث</span></div>
        
        <nav>
            <a href="{{ route('home') }}" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i> <span>لوحة التحكم</span>
            </a>
            <a href="{{ route('rooms.index') }}" class="nav-link"> 
                <i class="fas fa-chair"></i> <span>إدارة المنتجات</span>
            </a>
            <a href="{{ route('admin.sections') }}" class="nav-link"> 
                <i class="fas fa-layer-group"></i> <span>الأقسام</span>
            </a>
            <a href="#" class="nav-link"> 
                <i class="fas fa-cog"></i> <span>إعدادات المتجر</span>
            </a>
        </nav>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> <span>تسجيل خروج</span>
            </button>
        </form>
    </div>

    <div class="main-content">
        
        <div class="header-top">
            <h1 class="welcome-msg">مرحباً، <span>{{ Auth::user()->name }}</span></h1>
            
            <div class="notifications-wrapper">
    <div class="bell-icon">
        <i class="fas fa-bell"></i>
    </div>
    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
    
    {{-- أضفنا id="unread-count-badge" للتحكم فيه --}}
    @if($unreadCount > 0)
        <span class="unread-badge" id="unread-count-badge">{{ $unreadCount }}</span>
    @endif

    <div class="notifications-dropdown">
        <div class="dropdown-header">
            <span>تنبيهات الطلبات</span>
            @if($unreadCount > 0)
                {{-- أضفنا id="unread-count-text" هنا أيضاً --}}
                <span style="color:var(--color-secondary)" id="unread-count-text">{{ $unreadCount }} جديد</span>
            @endif
        </div>
        
        @forelse(auth()->user()->unreadNotifications as $notification)
            {{-- أضفنا class="notification-link" و data-id --}}
            <a href="{{ route('admin.notifications.read', $notification->id) }}" 
               class="notification-item notification-link" 
               data-id="{{ $notification->id }}">
                <div class="notif-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="notif-body">
                    <b>{{ $notification->data['message'] }}</b>
                    <small><i class="far fa-clock"></i> {{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </a>
        @empty
            <div class="no-notif">
                <i class="fas fa-bell-slash" style="font-size: 2em; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                لا توجد إشعارات غير مقروءة
            </div>
        @endforelse
    </div>
</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-box">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $rooms->count() }}</h3>
                    <p>إجمالي المنتجات</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-box">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="stat-info">
                    <p>تحديث المخزون</p>
                    <a href="{{ route('create') }}" class="action-btn">إضافة منتج</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-box">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-info">
                <a href="{{ route('admin.orders.index') }}" class="action-btn">الطلبات </a>
                   
                </div>
            </div>
        </div>

    </div> 
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationLinks = document.querySelectorAll('.notification-link');
    
    notificationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // إيقاف الانتقال الفوري
            
            const url = this.getAttribute('href');
            const badge = document.getElementById('unread-count-badge');
            const textBadge = document.getElementById('unread-count-text');

            // 1. تحديث العدادات في الصفحة فوراً (UI Update)
            if (badge) {
                let currentCount = parseInt(badge.innerText);
                if (currentCount > 1) {
                    badge.innerText = currentCount - 1;
                    if (textBadge) textBadge.innerText = (currentCount - 1) + " جديد";
                } else {
                    badge.remove(); // إزالة الدائرة تماماً لو كان آخر إشعار
                    if (textBadge) textBadge.remove();
                }
            }

            // 2. إرسال طلب خفي للسيرفر لتعليم الإشعار كمقروء ثم الانتقال
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).finally(() => {
                // الانتقال للرابط بعد انتهاء الطلب (أو حتى لو فشل لضمان وصول المستخدم)
                window.location.href = url;
            });
        });
    });
});
</script>

</body>
</html>