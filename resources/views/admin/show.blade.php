<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض تفاصيل: {{ $room->room_name }} | لوحة تحكم الفرش الذهبي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --color-white: #ffffff;
            --color-light-grey: #f0f2f5;
            --color-dark: #2c3e50;
            --color-accent-gold: #C8A461;
            --color-danger: #e74c3c;
            --color-success: #2ecc71;
            --color-warning: #f1c40f;
            --font-main: 'Cairo', sans-serif;
            --border-color: #e6e9ed;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font-main); background-color: var(--color-light-grey); direction: rtl; padding: 40px 20px; }

        .container { max-width: 1000px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: var(--color-dark); border-right: 5px solid var(--color-accent-gold); padding-right: 15px; }

        .btn-edit { background: var(--color-success); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; }
        .btn-edit:hover { background: #27ae60; }
        
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid var(--border-color); margin-bottom: 20px; }
        
        /* Details and Status */
        .detail-row { display: flex; justify-content: space-between; border-bottom: 1px dashed #eee; padding: 10px 0; }
        .detail-label { font-weight: 600; color: var(--color-text-secondary); }
        .detail-value { font-weight: 500; color: var(--color-dark); }

        .status-badge { padding: 5px 15px; border-radius: 20px; font-weight: 700; display: inline-block; }
        .published { background: #e8f8f0; color: var(--color-success); }
        .draft { background: #fef9e7; color: var(--color-warning); }
        .featured { background: #fbeee6; color: var(--color-accent-gold); }

        /* Description */
        .description-content { line-height: 1.8; color: #555; }
        
        /* Images Gallery */
        .image-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 20px; }
        .image-gallery img { width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; transition: transform 0.3s; cursor: pointer; }
        .image-gallery img:hover { transform: scale(1.05); }

        @media (max-width: 768px) {
            .content-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>تفاصيل المنتج: {{ $room->room_name }}</h1>
        <a href="{{ route('rooms.edit', $room->id) }}" class="btn-edit">
            <i class="fas fa-edit"></i> تعديل المنتج
        </a>
    </div>
    
    <p style="margin-bottom: 20px;">
        <a href="{{ route('rooms.index') }}" style="text-decoration: none; color: var(--color-dark); font-weight: 500;">
            <i class="fas fa-arrow-right"></i> العودة لقائمة المنتجات
        </a>
    </p>

    <div class="content-grid">
        <div>
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> معلومات المنتج الأساسية</h2>
                
                <div class="detail-row">
                    <span class="detail-label">الاسم:</span>
                    <span class="detail-value">{{ $room->room_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">التصنيف:</span>
                    <span class="detail-value">{{ $room->category->name ?? 'غير محدد' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">كود الغرفة (SKU):</span>
                    <span class="detail-value">{{ $room->sku ?? '---' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">تاريخ الإنشاء:</span>
                    <span class="detail-value">{{ $room->created_at->format('Y/m/d H:i') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">آخر تحديث:</span>
                    <span class="detail-value">{{ $room->updated_at->format('Y/m/d H:i') }}</span>
                </div>
            </div>

            <div class="card">
                <h2><i class="fas fa-file-alt"></i> الوصف التفصيلي</h2>
                <div class="description-content">
                    {{ $room->description ?? 'لا يوجد وصف طويل لهذا المنتج.' }}
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <h2><i class="fas fa-dollar-sign"></i> الأسعار والحالة</h2>
                
                <div class="detail-row">
                    <span class="detail-label">السعر الأصلي:</span>
                    <span class="detail-value">{{ number_format($room->price, 2) }} ج.م</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">الخصم:</span>
                    <span class="detail-value" style="color: var(--color-danger);">
                        {{ number_format($room->discount, 2) }} ج.م
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">الحالة:</span>
                    <span class="detail-value">
                        @if($room->is_published)
                            <span class="status-badge published"><i class="fas fa-globe"></i> منشور</span>
                        @else
                            <span class="status-badge draft"><i class="fas fa-archive"></i> مسودة</span>
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">مميز (Featured):</span>
                    <span class="detail-value">
                        @if($room->is_featured)
                            <span class="status-badge featured"><i class="fas fa-star"></i> نعم</span>
                        @else
                            <span class="status-badge draft">لا</span>
                        @endif
                    </span>
                </div>
            </div>

           

            <div class="card">
                <h2><i class="fas fa-images"></i> صور المنتج ({{ $room->images->count() }})</h2>
                <div class="image-gallery">
                    @forelse($room->images as $image)
                        @php
                            $path = asset('images/uploads/' . $image->image_path);
                        @endphp
                        <img src="{{ $path }}" alt="صورة رقم {{ $loop->iteration }}">
                    @empty
                        <p style="color: #999;">لا توجد صور مضافة لهذا المنتج.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>