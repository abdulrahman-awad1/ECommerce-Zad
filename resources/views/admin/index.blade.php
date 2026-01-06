<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات | لوحة تحكم الفرش الذهبي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --color-white: #ffffff;
            --color-light-grey: #f0f2f5;
            --color-dark: #2c3e50;
            --color-accent-gold: #C8A461;
            --color-success: #2ecc71;
            --color-danger: #e74c3c;
            --color-warning: #f1c40f;
            --color-text-secondary: #95a5a6;
            --font-main: 'Cairo', sans-serif;
            --border-color: #e6e9ed;

            --color-sidebar-bg: var(--color-dark); 
            --color-primary: #34495e; 
            --color-secondary: var(--color-accent-gold); 
        }

        * { box-sizing: border-box; margin: 0; padding: 0; text-decoration: none; }
        body { font-family: var(--font-main); background-color: var(--color-light-grey); direction: rtl; }

        .admin-wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            background-color: var(--color-sidebar-bg);
            color: var(--color-white);
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2); 
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .logo {
            text-align: center;
            padding: 10px 20px 30px;
            font-size: 1.5em;
            font-weight: 700;
            color: var(--color-secondary);
        }
        .logo span {
            color: var(--color-accent-gold); 
        }

        .nav-link {
            display: block;
            padding: 15px 20px;
            color: var(--color-white);
            transition: background-color 0.3s;
            border-right: 5px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--color-primary);
            border-right-color: var(--color-secondary);
        }

        .nav-link i {
            margin-left: 10px;
            width: 20px;
        }
        
        .logout-btn {
            background-color: #e74c3c;
            color: var(--color-white);
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            width: 80%;
            margin: 30px auto 0;
            display: block;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 700;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }

        .main-content { 
            flex-grow: 1; 
            padding: 30px; 
            margin-right: 250px; 
        }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .content-header h1 { font-size: 1.8em; color: var(--color-dark); }
        
        .btn-add-product { background-color: var(--color-accent-gold); color: var(--color-dark); padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-add-product:hover { background-color: #b38f4d; transform: translateY(-2px); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; display: flex; align-items: center; gap: 15px; border-right: 5px solid var(--color-accent-gold); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .stat-card i { font-size: 2em; color: var(--color-accent-gold); }

        .products-table-container { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid var(--border-color); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { padding: 15px; text-align: right; color: var(--color-dark); border-bottom: 2px solid var(--border-color); }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }

        .product-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid #eee; }
        
        .status { padding: 4px 10px; border-radius: 20px; font-size: 0.8em; font-weight: 600; display: inline-block; margin-top: 5px; }
        .status.published { background: #e8f8f0; color: var(--color-success); }
        .status.draft { background: #fef9e7; color: var(--color-warning); }
        .status.featured { background: #fbeee6; color: var(--color-accent-gold); }

        .actions-btn { display: flex; gap: 8px; }
        .btn { padding: 8px; border-radius: 6px; border: none; cursor: pointer; transition: 0.2s; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-view { background: #3498db; }
        .btn-edit { background: var(--color-success); }
        .btn-delete { background: var(--color-danger); }
        
        .alert-success { background: var(--color-success); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div class="sidebar">
        <div class="logo">لوحة إدارة <span>زاد</span></div>
        
        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i> لوحة التحكم
        </a>
        <a href="{{ route('rooms.index') }}" class="nav-link active"> 
            <i class="fas fa-chair"></i> إدارة المنتجات
        </a>
        <a href="{{ route('admin.sections') }}" class="nav-link"> 
            <i class="fas fa-boxes"></i> الأقسام
        </a>
        <a href="{{-- route('settings.index')--}}" class="nav-link"> 
            <i class="fas fa-cog"></i> اعدادات المتجر
        </a>
    

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> تسجيل خروج
            </button>
        </form>
    </div>

    <main class="main-content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="content-header">
            <h1>إدارة الغرف والمنتجات</h1>
            <a href="{{ route('create') }}" class="btn-add-product"> 
                <i class="fas fa-plus"></i> إضافة غرفة جديدة
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-boxes"></i>
                <div class="stat-info">
                    <p style="color: var(--color-text-secondary); font-size: 0.9em;">إجمالي الغرف</p>
                    <p style="font-size: 1.5em; font-weight: 700;">{{ $rooms->count() }}</p>
                </div>
            </div>
            <div class="stat-card" style="border-right-color: var(--color-success);">
                <i class="fas fa-globe" style="color: var(--color-success);"></i>
                <div class="stat-info">
                    <p style="color: var(--color-text-secondary); font-size: 0.9em;">غرف منشورة</p>
                    <p style="font-size: 1.5em; font-weight: 700;">{{ $rooms->where('is_published', true)->count() }}</p>
                </div>
            </div>
            <div class="stat-card" style="border-right-color: var(--color-success);">
                <i class="fas fa-globe" style="color: var(--color-success);"></i>
                <div class="stat-info">
                    <p style="color: var(--color-text-secondary); font-size: 0.9em;">غرف مميزة</p>
                    <p style="font-size: 1.5em; font-weight: 700;">{{ $rooms->where('is_featured', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="products-table-container">
            @if($rooms->isEmpty())
                <p style="text-align: center; color: var(--color-text-secondary); padding: 20px;">لا توجد منتجات مضافة حتى الآن.</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>صورة</th>
                        <th>اسم الغرفة</th>
                        <th>التصنيف</th>
                        <th>السعر</th>
                        <th>السعر بعد الخصم</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td>
                            @if($room->images && $room->images->count())
                                @php
                                    $path = $room->images->first()->image_path;
                                    if (!\Illuminate\Support\Str::startsWith($path, ['http', '/'])) {
                                        $path = asset('images/uploads/' . $path);
                                    }
                                @endphp
                                <img src="{{ $path }}" class="product-img" alt="صورة الغرفة">
                            @else
                                <img src="https://via.placeholder.com/60x60?text=No+Image" class="product-img" alt="لا توجد صورة">
                            @endif
                        </td>
                        <td>
                            <strong>{{ $room->room_name }}</strong><br>
                        </td>
                        <td>{{ $room->category->name ?? 'غير مصنف' }}</td> 
                        <td>{{ number_format($room->price + ($room->discount ?? 0), 2) }} ج.م</td>
                        <td>{{ number_format($room->price , 2) }} ج.م</td>
                        <td>
                            @if($room->is_published)
                                <span class="status published">منشور</span>
                            @else
                                <span class="status draft">مسودة</span>
                            @endif
                            @if($room->is_featured)
                                <span class="status featured"><i class="fas fa-star"></i> مميز</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-btn">
                                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-view" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-edit" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</div>

</body>
</html>