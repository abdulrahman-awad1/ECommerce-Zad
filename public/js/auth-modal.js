// دالة الإغلاق الكامل (تُستدعى فقط عند الضغط على زر إغلاق أو Esc)
function closeSearch() {
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto';
    input.value = ''; // مسح سجل البحث
}

// إغلاق عند الضغط على Esc
document.addEventListener('keydown', (e) => {
    if (e.key === "Escape") closeSearch();
});

document.addEventListener('DOMContentLoaded', () => {
    const authBtn = document.getElementById('auth-btn');
    const authModal = document.getElementById('auth-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const loginTabBtn = document.getElementById('login-tab-btn');
    const registerTabBtn = document.getElementById('register-tab-btn');
    const modalTitle = document.getElementById('modal-title');

    // فتح وإغلاق النافذة
    if (authBtn) {
        authBtn.addEventListener('click', () => {
            authModal.style.display = 'flex';
        });
    }

    const closeModal = () => {
        authModal.style.display = 'none';
    };

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);

    window.addEventListener('click', (e) => {
        if (e.target === authModal) closeModal();
    });

    // تبديل النماذج
    window.switchAuthMode = function(mode) {
        if (mode === 'login') {
            loginTabBtn.classList.add('active');
            registerTabBtn.classList.remove('active');
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            modalTitle.textContent = 'تسجيل الدخول';
        } else {
            registerTabBtn.classList.add('active');
            loginTabBtn.classList.remove('active');
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            modalTitle.textContent = 'تسجيل جديد';
        }
    };

    loginTabBtn.addEventListener('click', () => switchAuthMode('login'));
    registerTabBtn.addEventListener('click', () => switchAuthMode('register'));

    // دالة المبادرة (تستدعى من HTML للتعامل مع أخطاء Laravel)
   
});

