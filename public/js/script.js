const input = document.getElementById('searchInput');
const overlay = document.getElementById('searchOverlay');
const grid = document.getElementById('searchResultsGrid');

input.addEventListener('keyup', function () {
    const q = this.value;

    // إذا كان النص أقل من حرفين، نخفي النافذة فقط "بدون مسح النص"
    if (q.length < 2) {
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        return;
    }

    // إظهار نافذة النتائج
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 
    grid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 50px;">جاري البحث عن غرفتك المفضلة...</div>';

    fetch(`/ajax-search?q=${q}`)
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = '<div style="grid-column: 1/-1; text-align:center; padding: 50px;">لم نجد نتائج مطابقة لبحثك.</div>';
            } else {
                data.forEach(room => {
                    html += `
                        <div class="result-card">
                            <img src="${room.image ?? '/images/no-image.jpg'}">
                            <div class="result-card-body">
                                <h3>${room.name}</h3>
                                <h5>${room.description ?? ''}</h5>
                                <span class="price">${room.price} ج.م</span>
                                <a href="${room.url}" class="view-btn">عرض التفاصيل</a>
                            </div>
                        </div>
                    `;
                });
            }
            grid.innerHTML = html;
        });
});

document.getElementById('notifyToggle')?.addEventListener('click', function () {
    document.getElementById('notifyDropdown').classList.toggle('open');
});




document.addEventListener('DOMContentLoaded', function() {
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');

    if (notifBtn) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // منع وصول الضغطة للعناصر الخلفية
            notifDropdown.classList.toggle('show');
        });

        // إغلاق القائمة عند الضغط في أي مكان خارجها
        document.addEventListener('click', function(e) {
            if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });
    }
});
function closeAlertNow() {
    const alertElement = document.getElementById('successAlert');
    if (alertElement) {
        alertElement.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        alertElement.style.opacity = "0";
        alertElement.style.transform = "translateX(50px)"; // حركة جانبية بسيطة للديسك توب
        
        setTimeout(() => {
            alertElement.remove();
        }, 600);
    }
}

/**
 * إعداد الإخفاء التلقائي وشريط التقدم
 */
document.addEventListener('DOMContentLoaded', function() {
    const alertElement = document.getElementById('successAlert');
    const progressBar = alertElement ? alertElement.querySelector('.progress-bar') : null;

    if (alertElement) {
        // 1. تشغيل أنيميشن شريط التقدم عبر CSS (لو موجود)
        if (progressBar) {
            progressBar.style.transition = "width 5s linear";
            progressBar.style.width = "0%";
        }

        // 2. إغلاق التنبيه بعد 5 ثوانٍ
        setTimeout(closeAlertNow, 3000);
    }
    
});
