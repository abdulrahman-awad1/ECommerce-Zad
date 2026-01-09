
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInputMobile');
    const grid = document.getElementById('searchResultsGridMobile');
    const overlay = document.getElementById('searchOverlay');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let q = this.value;

            if (q.length > 1) {
                // عرض رسالة "جاري البحث"
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 50px;">جاري البحث عن غرفتك المفضلة...</div>';

                // استخدام المسار الخاص بك /ajax-search
                fetch(`/ajax-search?q=${q}`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        if (data.length === 0) {
                            html = '<div style="grid-column: 1/-1; text-align:center; padding: 50px;">لم نجد نتائج مطابقة لبحثك.</div>';
                        } else {
                            data.forEach(room => {
                                // بناء الكارت بتصميم مناسب للموبايل
                                html += `
                                    <div class="result-card" style="background: #fff; border: 1px solid #eee; border-radius: 10px; overflow: hidden; display: flex; flex-direction: column;">
                                        <img src="${room.image ?? '/images/no-image.jpg'}" style="width: 100%; height: 130px; object-fit: cover;">
                                        <div style="padding: 10px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                            <div>
                                                <h3 style="font-size: 0.9rem; margin: 0 0 5px 0; color: #333;">${room.name}</h3>
                                                <p style="font-size: 0.75rem; color: #777; margin: 0; line-height: 1.2;">${room.description ?? ''}</p>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <span style="display: block; color: #b08d57; font-weight: bold; font-size: 0.9rem; margin-bottom: 8px;">${room.price} ج.م</span>
                                                <a href="${room.url}" style="display: block; background: #333; color: #fff; text-align: center; padding: 6px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        }
                        grid.innerHTML = html;
                    })
                    .catch(err => {
                        grid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 50px; color: red;">حدث خطأ أثناء البحث.</div>';
                    });
            } else {
                // الحالة الافتراضية عند مسح النص
                grid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; color: #ccc; margin-top: 50px;">
                        <i class="fas fa-search" style="font-size: 3rem; opacity: 0.2; display: block; margin-bottom: 10px;"></i>
                        <p>ابدأ بالكتابة للبحث عن المنتجات</p>
                    </div>`;
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const notifBtn = document.getElementById('notifBtnMobile');
    const notifDropdown = document.getElementById('notifDropdownMobile');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // التعديل هنا: نتحقق من الحالة الفعلية المحسوبة للعنصر
            const isHidden = window.getComputedStyle(notifDropdown).display === 'none';
            
            if (isHidden) {
                notifDropdown.style.display = 'block';
            } else {
                notifDropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', function() {
            notifDropdown.style.display = 'none';
        });

        notifDropdown.addEventListener('click', function(e) {
            e.stopPropagation(); 
        });
    }
});

function toggleSideMenu() {
    const menu = document.getElementById('sideMenuMobile');
    const overlay = document.getElementById('sideMenuOverlay');
    
    if (menu.style.right === '0px') {
        menu.style.right = '-100%';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    } else {
        menu.style.right = '0px';
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function toggleSideCart() {
    const cart = document.getElementById('sideCartMobile');
    const overlay = document.getElementById('sideCartOverlay');
    
    // بما أن السلة تفتح من اليسار نستخدم الـ left
    if (cart.style.left === '0px') {
        cart.style.left = '-100%';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    } else {
        cart.style.left = '0px';
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

