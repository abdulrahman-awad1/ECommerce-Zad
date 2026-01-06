/**
 * دالة تغيير الصورة الرئيسية عند الضغط على الصور المصغرة
 */
function changeMainImage(src, elm) {
    const mainImg = document.getElementById('mainRoomImage');
    if (mainImg) {
        mainImg.src = src;
    }
    
    // تحديث الحالة النشطة (Active) للصور المصغرة
    const thumbnails = document.querySelectorAll('.image-slider img');
    thumbnails.forEach(img => img.classList.remove('active'));
    elm.classList.add('active');
}

/**
 * دالة التنقل بين التبويبات (الوصف، المواصفات، إلخ)
 */
function switchTab(evt, tabId) {
    // إخفاء كافة محتويات التبويبات
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));
    
    // إلغاء تفعيل كافة أزرار التبويبات
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    // إظهار التبويب المختار وتفعيل الزر الخاص به
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    evt.currentTarget.classList.add('active');
}