<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد | لوحة تحكم الفرش الذهبي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* ========================================================= */
        /* I. الألوان والثوابت الأساسية (مُحسنة)                      */
        /* ========================================================= */
        :root {
            --color-white: #ffffff;
            --color-light-grey: #f0f2f5; 
            --color-dark: #2c3e50; 
            --color-accent-gold: #C8A461; 
            --color-success: #1abc9c; 
            --color-danger: #e74c3c;
            --color-warning: #f1c40f; 
            --color-text-secondary: #95a5a6;
            --font-main: 'Cairo', sans-serif;
            --spacing-large: 40px;
            --spacing-medium: 25px;
            --spacing-small: 15px;
            --border-color: #e6e9ed;

            /* ثوابت خاصة بالستايل القديم */
            --color-sidebar-bg: var(--color-dark); 
            --color-primary: #34495e; 
            --color-secondary: var(--color-accent-gold); 
        }

        /* ========================================================= */
        /* II. إعادة التعيين والأساسيات                   */
        /* ========================================================= */
        * { box-sizing: border-box; margin: 0; padding: 0; text-decoration: none; }
        body { 
            font-family: var(--font-main); 
            line-height: 1.6; 
            color: var(--color-dark); 
            background-color: var(--color-light-grey); 
            direction: rtl; 
            text-align: right; 
            font-weight: 400;
        }
        
        a { text-decoration: none; color: inherit; }

        /* ========================================================= */
        /* III. تصميم لوحة التحكم (Dashboard Layout)                 */
        /* ========================================================= */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* القائمة الجانبية (Sidebar) - تم التعديل هنا ليتطابق مع Index */
        .sidebar {
            width: 250px; /* العرض القديم */
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

        .nav-link:hover {
            background-color: var(--color-primary); /* #34495e */
            border-right-color: var(--color-secondary);
        }

        .nav-link.active {
            background-color: var(--color-primary);
            border-right-color: var(--color-secondary);
        }

        .nav-link i {
            margin-left: 10px;
            width: 20px;
        }
        
        .logout-btn {
            background-color: var(--color-danger);
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
        /* نهاية التعديل على Sidebar CSS */


        /* المحتوى الرئيسي */
        .main-content { 
            flex-grow: 1; 
            padding: var(--spacing-large); 
            margin-right: 250px; /* تعويض حجم الـ Sidebar الثابت */
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-large);
            padding-bottom: var(--spacing-small);
        }

        .content-header h1 { 
            font-size: 2.4em; 
            color: var(--color-dark); 
            font-weight: 700;
            border-bottom: 2px solid var(--color-accent-gold);
            padding-bottom: 5px;
        }
        
        .cta-btn { 
            background-color: var(--color-dark); 
            color: var(--color-white); 
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.3s;
        }
        .cta-btn i {
            margin-right: 8px; 
        }
        .cta-btn:hover { 
            background-color: var(--color-accent-gold); 
            color: var(--color-dark);
        }


        /* ========================================================= */
        /* IV. تصميم نموذج إضافة المنتج (Form Styling)              */
        /* ========================================================= */
        
        .form-container { display: flex; gap: var(--spacing-medium); flex-wrap: wrap; }
        
        .form-card {
            background-color: var(--color-white);
            padding: var(--spacing-medium);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); 
            margin-bottom: var(--spacing-medium);
            border: 1px solid var(--border-color);
        }
        
        /* تخطيط البطاقات */
        .details-card { flex: 2; min-width: 60%; }
        .media-settings-card { flex: 1; min-width: 300px; }
        /* تنسيق جديد لتنظيم حقول السعر والخصم في صف واحد */
        .price-group { 
            display: flex; 
            gap: var(--spacing-small);
        }
        .price-group .form-group {
            flex: 1;
            min-width: 48%; 
        }
        /* نهاية التنسيق الجديد */


        .form-card h2 {
            font-size: 1.6em;
            padding-bottom: var(--spacing-small);
            margin-bottom: var(--spacing-medium);
            color: var(--color-dark);
            border-left: 4px solid var(--color-accent-gold); 
            padding-right: 10px;
        }
        
        .form-card h3 {
             font-size: 1.2em; 
             margin-top: var(--spacing-medium); 
             margin-bottom: 15px; 
             color: var(--color-dark);
             border-bottom: 1px dashed var(--border-color);
             padding-bottom: 5px;
        }

        /* تنسيق الحقول */
        .form-group { margin-bottom: var(--spacing-medium); }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--color-dark);
        }

        .form-group input:not([type="checkbox"]):not([type="file"]), 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: var(--font-main);
            font-size: 1em;
            background-color: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: var(--color-accent-gold);
            box-shadow: 0 0 0 3px rgba(200, 164, 97, 0.2); 
            background-color: var(--color-white);
            outline: none;
        }

        textarea { resize: vertical; min-height: 120px; }

        /* رسائل الأخطاء (Blade) */
        p.error {
            background-color: var(--color-danger);
            color: var(--color-white);
            padding: 8px 15px;
            border-radius: 4px;
            margin: 5px 0 15px 0;
            font-size: 0.9rem;
            text-align: right;
            font-weight: 600;
        }
        
        /* رسائل النجاح (Blade) */
        .success-message {
            background-color: var(--color-success);
            color: var(--color-white);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: var(--spacing-medium);
            text-align: center;
            font-weight: 700;
            box-shadow: 0 2px 10px rgba(26, 188, 156, 0.4);
        }

        /* زر رفع الملفات (Images) */
        .image-upload-area {
            border: 2px dashed #bbb;
            background-color: #fcfcfc;
            padding: var(--spacing-medium);
            text-align: center;
            cursor: pointer;
            border-radius: 6px;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .image-upload-area:hover { 
            border-color: var(--color-accent-gold); 
            background-color: #fff8f0;
        }
        
        .image-upload-area i {
            font-size: 2.5em;
            color: var(--color-accent-gold);
            margin-bottom: 10px;
        }
        .image-upload-area p {
             color: var(--color-text-secondary);
        }

        /* زر الحفظ */
        .action-buttons {
            text-align: right;
            padding-top: var(--spacing-medium);
        }

        .save-btn {
            background-color: var(--color-success);
            color: var(--color-white);
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 1.1em;
        }

        .save-btn:hover { 
            background-color: #16a085;
            transform: translateY(-2px);
        }

        /* ========================================================= */
        /* V. التجاوب (Media Queries)              */
        /* ========================================================= */
        @media (max-width: 992px) {
            .admin-wrapper { flex-direction: column; }
            .sidebar { 
                width: 100%; 
                padding: var(--spacing-small) 0; 
                position: relative; 
                height: auto; 
            }
            /* جعل الروابط الأفقية أكثر تنظيماً في الجوال */
            .sidebar a {
                display: block; 
                text-align: center; 
                border-right: none;
                border-bottom: 3px solid transparent; 
            }
            .sidebar .nav-link i { display: none; }
            .sidebar .logo, .sidebar .logout-btn { display: none; }
            
            .main-content { padding: var(--spacing-medium); margin-right: 0; }
            .details-card, .media-settings-card { min-width: 100%; flex: 100%; }
            /* جعل مجموعتي السعر والخصم عموديتين على الشاشات الصغيرة */
            .price-group { flex-direction: column; }
            .price-group .form-group { min-width: 100%; }
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
            <a href="{{ route('rooms.index') }}" class="nav-link active"> 
                <i class="fas fa-chair"></i> إدارة المنتجات
            </a>
            <a href="{{ route('admin.sections') }}" class="nav-link"> 
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
                <h1><i class="fas fa-plus-circle"></i> إضافة منتج جديد</h1>
                <a href="{{ route('rooms.index') }}" class="cta-btn">
                    <i class="fas fa-arrow-right"></i> العودة لقائمة المنتجات
                </a>
            </div>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{route('rooms.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-container">
                    
                    <div class="form-card details-card">
                        <h2>التفاصيل الأساسية والوصف</h2>
                        <div class="form-group">
                            <label for="category_id">التصنيف الرئيسي (اسم القسم):</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">اختر القسم</option>
                                <option value=1 {{ old('category_id') == 1 ? 'selected' : '' }}>غرف نوم</option>
                                <option value=2 {{ old('category_id') == 2 ? 'selected' : '' }}>غرف اطفال</option>
                                <option value=3 {{ old('category_id') == 3 ? 'selected' : '' }}>صالون</option>
                                <option value=4 {{ old('category_id') == 4 ? 'selected' : '' }}>سفرة</option>
                                <option value=5 {{ old('category_id') == 5 ? 'selected' : '' }}>انتريهات</option>
                                <option value=6 {{ old('category_id') == 6 ? 'selected' : '' }}>فرادنيات</option>
                            </select>
                            @error('category_id') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="room_name">اسم الغرفة/المنتج:</label>
                            <input type="text" id="room_name" name="room_name" value="{{ old('room_name') }}" required placeholder="مثال: غرفة نوم ملكية طراز إليف">
                            @error('room_name') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">رمز المنتج (SKU):</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" placeholder="مثال: BED-ELIF-001">
                            @error('sku') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <div class="price-group">
                            <div class="form-group">
                                <label for="price">السعر الأساسي (ج.م):</label>
                                <input type="number" id="price" name="price" value="{{ old('price') }}" required placeholder="أدخل السعر">
                                @error('price') <p class="error">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="discount">قيمة الخصم (ج.م أو %):</label>
                                <input type="text" id="discount" name="discount" value="{{ old('discount') }}" placeholder="مثال: 500 أو 10%">
                                @error('discount') <p class="error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف:</label>
                            <textarea id="description" name="description" rows="5" required placeholder="وصف تفصيلي للغرفة، المواد المستخدمة، والمقاسات الأساسية.">{{ old('description') }}</textarea>
                            @error('description') <p class="error">{{ $message }}</p> @enderror
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="form-card media-settings-card">
                        <h2>الصور والإعدادات</h2>
                        
                        <div class="form-group">
                            <label for="images">اختر الصور:</label>
                             <input type="file" id="images" name="images[]" accept="image/*" multiple required style="display: none;">
                            
                            <div class="image-upload-area" onclick="document.getElementById('images').click()">
                                <i class="fas fa-upload"></i>
                                <p>اضغط لتحميل الصور</p>
                                <span id="file-count" style="font-size: 0.9em; color: var(--color-accent-gold);"></span>
                            </div>

                            @error('images') <p class="error">{{ $message }}</p> @enderror
                            @error('images.*') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <h3>إعدادات النشر</h3>

                        <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                            <input type="checkbox" id="is_published" name="is_published" checked style="width: auto;">
                            <label for="is_published" style="margin-bottom: 0; font-weight: 400;">نشر المنتج الآن</label>
                        </div>
                        
                        <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                            <input type="checkbox" id="is_featured" name="is_featured" style="width: auto;">
                            <label for="is_featured" style="margin-bottom: 0; font-weight: 400;">عرض كمنتج مميز</label>
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="action-buttons form-card">
                    <button type="submit" class="save-btn">
                        <i class="fas fa-check"></i> حفظ
                    </button>
                </div>

            </form>
            
        </main>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('images');
            const fileCountSpan = document.getElementById('file-count');
            const uploadText = document.querySelector('.image-upload-area p');

            fileInput.addEventListener('change', () => {
                const fileCount = fileInput.files.length;
                if (fileCount > 0) {
                    fileCountSpan.textContent = `تم اختيار ${fileCount} ملفات.`;
                    uploadText.textContent = `جاهز للرفع.`;
                } else {
                    fileCountSpan.textContent = '';
                    uploadText.textContent = `اضغط لتحميل الصور`;
                }
            });
        });
    </script>

</body>
</html>