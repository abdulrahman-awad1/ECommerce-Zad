<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب #{{ $order->id }} | إدارة زاد</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}?v={{ time() }}">

    
    {{-- تم الإبقاء على الـ CSS كما هو لضمان التنسيق --}}
   
</head>
<body>

<div class="container">

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <div class="order-header">
        <div>
            <h1 style="margin:0; font-size: 1.5rem;">تفاصيل الطلب <span style="color:var(--color-secondary)">#{{ $order->id }}</span></h1>
            <span class="badge status-{{ $order->status }}">
                حالة الطلب الحالية: {{ $order->status_label }}
            </span>
        </div>

        <div class="header-actions">
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-update-form">
                @csrf
                <i class="fas fa-edit" style="color: #7f8c8d; margin-right: 5px;"></i>
                <select name="status" class="status-select">
                    @foreach($status_options as $value => $label)
                        <option value="{{ $value }}" @selected($order->status == $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-update">تحديث</button>
            </form>

            <a href="{{ route('admin.orders.index') }}" class="btn-back">
                <i class="fas fa-arrow-right"></i> رجوع
            </a>
        </div>
    </div>

    <div class="info-grid">
        {{-- بيانات العميل --}}
        <div class="info-card">
            <h3><i class="fas fa-user-circle"></i> بيانات العميل</h3>
            <div class="info-item">
                <span class="info-label">الاسم:</span>
                <span class="info-value">{{ $order->customer_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">الإيميل:</span>
                <span class="info-value">{{ $order->customer_email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">الهاتف:</span>
                <span class="info-value">{{ $order->customer_phone }}</span>
            </div>
        </div>

        {{-- عنوان الشحن --}}
        <div class="info-card">
            <h3><i class="fas fa-truck"></i> عنوان الشحن</h3>
            @if($order->has_address)
                <div class="info-item"><span class="info-label">الدولة:</span><span class="info-value">{{ $order->address->country }}</span></div>
                <div class="info-item"><span class="info-label">المدينة:</span><span class="info-value">{{ $order->address->city }}</span></div>
                <div class="info-item"><span class="info-label">العنوان:</span><span class="info-value">{{ $order->address->street }}</span></div>
            @else
                <p style="color: #e74c3c;">لا توجد بيانات عنوان مسجلة لهذا الطلب.</p>
            @endif
        </div>

        {{-- توقيت الطلب --}}
        <div class="info-card">
            <h3><i class="fas fa-calendar-alt"></i> توقيت الطلب</h3>
            <div class="info-item">
                <span class="info-label">التاريخ:</span>
                <span class="info-value">{{ $order->formatted_date }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">الوقت:</span>
                <span class="info-value">{{ $order->formatted_time }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">طريقة الدفع:</span>
                <span class="info-value">{{ $order->payment_method }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">حالة الدفع:</span>
                <span class="info-value">{{ $order->payment_status }}</span>
            </div>
        </div>
    </div>

    <div class="products-card">
        <h3><i class="fas fa-boxes"></i> المنتجات المطلوبة</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order_items as $item)
                <tr>
                    <td><img src="{{ $item['image'] }}" class="product-img"></td>
                    <td>
                        <div style="font-weight: bold;">{{ $item['name'] }}</div>
                        <small style="color: #999;">SKU: {{ $item['sku'] }}</small>
                    </td>
                    <td>{{ $item['price_formatted'] }} ج.م</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td><strong>{{ $item['subtotal_formatted'] }} ج.م</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-summary">
            <hr style="border: 0; border-top: 1px solid #ddd;">
            <div class="summary-row">
                <span style="font-weight: bold;">الإجمالي النهائي:</span>
                <span class="total-price">{{ $total }} ج.م</span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>

</body>
</html>