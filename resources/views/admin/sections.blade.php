<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة التصنيفات | لوحة تحكم الفرش الذهبي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --color-white: #ffffff;
            --color-light-grey: #f0f2f5;
            --color-dark: #2c3e50;
            --color-accent-gold: #C8A461;
            --color-success: #1abc9c;
            --color-danger: #e74c3c;
            --color-text-secondary: #95a5a6;
            --font-main: 'Cairo', sans-serif;
            --border-color: #e6e9ed;

            /* ثوابت خاصة بالستايل القديم */
            --color-sidebar-bg: var(--color-dark); 
            --color-primary: #34495e; /* لون للخلفية عند التحويم */
            --color-secondary: var(--color-accent-gold); 
        }

        * { box-sizing: border-box; margin: 0; padding: 0; text-decoration: none; }
        body { font-family: var(--font-main); background-color: var(--color-light-grey); direction: rtl; }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* ========================================================= */
        /* تصميم الـ Sidebar الموحد (تم تعديله بالكامل)               */
        /* ========================================================= */
        .sidebar {
            width: 250px; /* العرض الموحد */
            background-color: var(--color-sidebar-bg);
            color: var(--color-white);
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2); 
            position: fixed; /* تثبيت الشريط الجانبي */
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
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
        /* ========================================================= */
        /* نهاية تصميم الـ Sidebar الموحد                          */
        /* ========================================================= */

        /* Content */
        .main-content { 
            flex-grow: 1; 
            padding: 40px; 
            margin-right: 250px; /* تعويض حجم الـ Sidebar */
        }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .content-header h1 { font-size: 2.2em; color: var(--color-dark); border-bottom: 3px solid var(--color-accent-gold); padding-bottom: 5px; }

        /* زر لإضافة تصنيف في صفحة منفصلة إذا أردت */
        .btn-create { background-color: var(--color-dark); color: var(--color-white); padding: 10px 20px; border-radius: 6px; font-weight: 600; transition: 0.3s; }
        .btn-create:hover { background-color: var(--color-accent-gold); color: var(--color-dark); }

        /* Full Width Table Card */
        .card { background: var(--color-white); padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid var(--border-color); width: 100%; }
        .card h2 { font-size: 1.4em; margin-bottom: 20px; color: var(--color-dark); border-right: 4px solid var(--color-accent-gold); padding-right: 15px; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th { background-color: #f8f9fa; color: var(--color-dark); text-align: right; padding: 15px; border-bottom: 2px solid var(--border-color); }
        table td { padding: 15px; border-bottom: 1px solid var(--border-color); color: #555; }
        
        .badge { background: #eef2f7; padding: 4px 12px; border-radius: 20px; font-size: 0.85em; color: var(--color-dark); font-weight: 600; border: 1px solid #d1d9e4; }
        
        /* Action Buttons */
        .actions { display: flex; gap: 10px; }
        .btn-edit { color: var(--color-success); border: 1px solid var(--color-success); padding: 6px 12px; border-radius: 4px; font-size: 0.9em; transition: 0.3s; }
        .btn-delete { color: var(--color-danger); border: 1px solid var(--color-danger); padding: 6px 12px; border-radius: 4px; font-size: 0.9em; transition: 0.3s; }
        .btn-edit:hover { background: var(--color-success); color: white; }
        .btn-delete:hover { background: var(--color-danger); color: white; }

        @media (max-width: 992px) {
            .sidebar { width: 100%; padding: 15px 0; position: relative; height: auto; }
            .sidebar .logo, .sidebar .logout-btn { display: none; }
            .sidebar a {
                display: block;
                text-align: center;
                border-right: none;
                border-bottom: 3px solid transparent; 
                flex-grow: 1;
                width: 25%;
                float: right;
            }
            .sidebar .nav-link i { display: none; }
            .main-content { padding: 20px; margin-right: 0; }
            .content-header h1 { font-size: 1.8em; }
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo">لوحة إدارة <span>زاد</span></div>
        
        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i> لوحة التحكم
        </a>
        <a href="{{ route('rooms.index') }}" class="nav-link"> 
            <i class="fas fa-chair"></i> إدارة المنتجات
        </a>
        <a href="{{ route('admin.sections') }}" class="nav-link active"> 
            <i class="fas fa-boxes"></i> الأقسام
        </a>
        <a href="{{-- route('settings.index') --}}" class="nav-link"> 
            <i class="fas fa-cog"></i> اعدادات المتجر
        </a>
    

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> تسجيل خروج
            </button>
        </form>
    </aside>

    <main class="main-content">
        <div class="content-header">
            <h1>إدارة التصنيفات</h1>
            
            
        </div>

        <section class="card">
            <h2>التصنيفات الحالية</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم التصنيف</th>
                        <th>إجمالي المنتجات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong>غرف نوم</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 1)->count() }}</span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 1) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>

                    </tr>
                    <tr>
                        <td>2</td>
                        <td><strong>غرف أطفال</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 2)->count() }}</span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 2) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><strong>صالونات</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 3)->count() }} </span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 3) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><strong>سفرة</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 4)->count() }} </span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 4) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><strong>انتريهات</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 5)->count() }} </span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 5) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td><strong>فرادنيات</strong></td>
                        <td><span class="badge">{{ $rooms->where('category_id', 6)->count() }} </span></td>
                        
                        <td class="actions">
                        <a href="{{ route('rooms.category', 6) }}" class="btn-edit" title="عرض">
                        <i class="fas fa-edit"></i> عرض
                        </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</div>

</body>
</html>