<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات | زاد للأثاث</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --color-primary: #34495e;
            --color-secondary: #C8A461;
            --color-light-bg: #ecf0f1;
            --color-sidebar-bg: #2c3e50;
            --color-white: #ffffff;
            --font-main: 'Cairo', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--color-light-bg);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* القائمة الجانبية */
        .sidebar {
            width: 260px;
            background-color: var(--color-sidebar-bg);
            color: var(--color-white);
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .sidebar .logo {
            text-align: center;
            padding: 30px 20px;
            font-size: 1.6em;
            font-weight: 700;
            color: var(--color-secondary);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
            border-right: 4px solid transparent;
        }

        .nav-link i { margin-left: 15px; width: 20px; }

        .nav-link:hover, .nav-link.active {
            background-color: var(--color-primary);
            color: var(--color-white);
            border-right-color: var(--color-secondary);
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-right: 260px;
            flex-grow: 1;
            padding: 40px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8em;
            color: var(--color-primary);
            margin: 0;
        }

        .page-title span { color: var(--color-secondary); }

        /* جدول الطلبات */
        .card {
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 25px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f8f9fa;
            color: #7f8c8d;
            padding: 15px;
            text-align: right;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 18px 15px;
            border-bottom: 1px solid #f1f1f1;
            color: #333;
        }

        /* حالات الطلب */
        .badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status-pending { background: #fff9eb; color: #d4a017; }
        .status-processing { background: #e3f2fd; color: #1976d2; }
        .status-delivering { background: #e8f5e9; color: #2e7d32; }
        .status-completed { background: #ebfbee; color: #2ecc71; border: 1px solid #2ecc71; }
        .status-cancelled { background: #fff1f0; color: #e74c3c; }

        /* فورم التحديث */
        .status-form {
            display: flex;
            gap: 8px;
        }

        .status-select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Cairo';
            outline: none;
            cursor: pointer;
        }

        .btn-save {
            background: var(--color-secondary);
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover { background: var(--color-primary); }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px;
            width: 80%;
            margin: 40px auto;
            display: block;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Cairo';
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">إدارة <span>زاد</span></div>
        
        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i> لوحة التحكم
        </a>
        <a href="{{ route('rooms.index') }}" class="nav-link">
            <i class="fas fa-chair"></i> إدارة المنتجات
        </a>
        <a href="#" class="nav-link active">
            <i class="fas fa-shopping-cart"></i> إدارة الطلبات
        </a>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> تسجيل خروج
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="header-top">
            <h1 class="page-title">إدارة <span>الطلبات</span></h1>
            <div style="color: #7f8c8d;">
                <i class="far fa-calendar-alt"></i> {{ date('Y-m-d') }}
            </div>
        </div>

        @if(session('success'))
            <div style="background: #2ecc71; color: white; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجمالي</th>
                        <th>الحالة</th>
                        <th>تحديث الحالة</th>
                        <th> عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <div style="font-weight: 700;">{{ $order->user->name ?? 'عميل زائر' }}</div>
                            <div style="font-size: 0.8em; color: #95a5a6;">{{ $order->phone ?? $order->user->email ?? '-' }}</div>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td style="color: var(--color-secondary); font-weight: 700;">{{ number_format($order->total_price) }} ج.م</td>
                        <td>
                            <span class="badge status-{{ $order->status }}">
                                @if($order->status == 'pending') قيد الانتظار
                                @elseif($order->status == 'processing') جاري التجهيز
                                @elseif($order->status == 'delivering') تم الشحن
                                @elseif($order->status == 'completed') مكتمل
                                @elseif($order->status == 'cancelled') ملغي
                                @else {{ $order->status }} @endif
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
                                @csrf
                                @method('post')
                                <select name="status" class="status-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>انتظار</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>تجهيز</option>
                                    <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>شحن</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>اكتمل</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>إلغاء</option>
                                </select>
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </td>
                        <td>
    <a href="{{ route('admin.orders.show', $order->id) }}" 
       class="btn-view" 
       title="عرض تفاصيل الطلب"
       style="color: var(--color-secondary); font-size: 1.2rem; transition: 0.3s; display: inline-block;">
        <i class="fas fa-eye"></i>
    </a>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($orders->isEmpty())
                <div style="text-align: center; padding: 50px; color: #bdc3c7;">
                    <i class="fas fa-box-open" style="font-size: 4em; margin-bottom: 15px; display: block;"></i>
                    لا يوجد طلبات مسجلة حالياً.
                </div>
            @endif
        </div>
    </div>

</body>
</html>