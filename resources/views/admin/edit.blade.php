<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الغرفة | لوحة تحكم الفرش الذهبي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin_edit.css') }}?v={{ time() }}">

    
    
</head>
<body>

<div class="container">
    <div class="header">
        <h1>تعديل بيانات: {{ $room->room_name }}</h1>
        <a href="{{ route('rooms.index') }}" style="text-decoration: none; color: var(--color-dark);"><i class="fas fa-arrow-left"></i> رجوع للكل</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>اسم الغرفة/المنتج:</label>
            <input type="text" name="room_name" value="{{ old('room_name', $room->room_name) }}" required>
            @error('room_name') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>التصنيف:</label>
                <select name="category_id">
                    <option value="1" {{ $room->category_id == 1 ? 'selected' : '' }}>غرف نوم</option>
                    <option value="2" {{ $room->category_id == 2 ? 'selected' : '' }}>غرف اطفال</option>
                    <option value="3" {{ $room->category_id == 3 ? 'selected' : '' }}>صالون</option>
                    <option value="4" {{ $room->category_id == 4 ? 'selected' : '' }}>سفرة</option>
                </select>
            </div>
            <div class="form-group">
                <label>السعر (ج.م):</label>
                <input type="number" name="price" value="{{ old('price', $room->price) }}" required>
            </div>
            <div class="form-group">
                <label>كود الغرفة:</label>
                <input type="string" name="sku" value="{{ old('sku', $room->sku) }}" >
            </div>
            <div class="form-group">
                <label>الخصم (ج.م):</label>
                <input type="number" name="discount" value="{{ old('discount', $room->discount) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>الوصف:</label>
            <textarea name="description" rows="4">{{ old('description', $room->description) }}</textarea>
        </div>

       
        <div class="form-group">
            <label>الصور الحالية للمنتج:</label>
            <div class="current-images">
            @foreach($room->images as $image)
            <div class="image-wrapper" id="image-{{ $image->id }}">
                <img src="{{ asset('images/uploads/' . $image->image_path) }}" alt="صورة">
                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="delete-checkbox" style="display:none;">
                
                <button type="button" class="delete-image-btn"
                        onclick="toggleDeleteImage(this, {{ $image->id }})">×</button>
            </div>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>إضافة صور جديدة (سيتم إضافتها للصور الحالية):</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>

        <div style="display: flex; gap: 20px; margin: 20px 0;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_published" {{ $room->is_published ? 'checked' : '' }} style="width: auto;"> نشر المنتج
            </label>
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_featured" {{ $room->is_featured ? 'checked' : '' }} style="width: auto;"> منتج مميز
            </label>
        </div>

        <button type="submit" class="btn-update">
            <i class="fas fa-save"></i> حفظ التعديلات
        </button>
    </form>
</div>

<script>
    function toggleDeleteImage(button, imageId) {
        const wrapper = document.getElementById('image-' + imageId);
        const checkbox = wrapper.querySelector('.delete-checkbox');
        
        // تبديل حالة الـ Checkbox
        checkbox.checked = !checkbox.checked;

        // تبديل شكل الـ Wrapper لإعطاء مؤشر بصري
        if (checkbox.checked) {
            wrapper.classList.add('deleted');
            button.style.background = 'var(--color-dark)';
            button.textContent = '✔️'; // مؤشر للحذف المؤكد
        } else {
            wrapper.classList.remove('deleted');
            button.style.background = 'var(--color-danger)';
            button.textContent = '×'; // مؤشر للإلغاء
        }
    }
</script>

</body>
</html>