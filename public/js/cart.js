document.addEventListener('DOMContentLoaded', function() {
    const cartToggle = document.getElementById('cartToggle');
    const cartDropdown = document.getElementById('cartDropdown');

    if (cartToggle && cartDropdown) {
        // فتح وإغلاق السلة
        cartToggle.onclick = function (e) {
            e.stopPropagation(); // منع انتشار الحدث لكي لا يغلق فوراً
            cartDropdown.classList.toggle('open');
        };

        // منع إغلاق السلة عند الضغط بداخل محتوياتها
        cartDropdown.onclick = function (e) {
            e.stopPropagation();
        };

        // إغلاق السلة عند الضغط في أي مكان آخر بالصفحة
        document.onclick = function () {
            cartDropdown.classList.remove('open');
        };
    }
});

window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // إخفاء محتوى الجسم فوراً لمنع رؤية البيانات القديمة
        document.body.style.display = 'none';
        // عمل التحديث
        window.location.reload(); 
    }
});