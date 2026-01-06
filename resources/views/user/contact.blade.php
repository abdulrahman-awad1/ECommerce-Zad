@extends('layouts.master')

@section('content')
<div style="background: var(--color-bg); padding: 10px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">تواصل معنا</h1>
        <p style="color: var(--color-text-muted); max-width: 600px; margin: 0 auto;">
            نحن هنا لمساعدتك في تحويل منزلك إلى لوحة فنية. تواصل معنا لأي استفسار حول منتجاتنا أو خدماتنا.
        </p>
        <div style="width: 60px; height: 3px; background: var(--color-gold); margin: 20px auto;"></div>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    <div class="contact-grid">
        
        <div class="info-panel">
            <h3 style="margin-bottom: 25px; border-right: 4px solid var(--color-gold); padding-right: 15px;">بيانات التواصل</h3>
            
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4 style="font-size: 1rem;">المعرض الرئيسي</h4>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem;">دمياط، عزب النهضة، شارع الموقف الجديد</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <h4 style="font-size: 1rem;">اتصل بنا</h4>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; direction: ltr;">+20 10 00408109</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4 style="font-size: 1rem;">البريد الإلكتروني</h4>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem;">info@zad-furniture.com</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-clock"></i>
                <div>
                    <h4 style="font-size: 1rem;">مواعيد العمل</h4>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem;">يومياً من 10:00 صباحاً حتى 11:00 مساءً</p>
                </div>
            </div>
        </div>

        <div class="social-box">
            <h3 style="margin-bottom: 25px;">تواصل سريع</h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="https://wa.me/+201000408109" target="_blank" class="social-btn btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> تحدث معنا عبر واتساب
                </a>
                <a href="https://www.facebook.com/share/1AkxmSTaXo/" class="social-btn btn-facebook">
                    <i class="fab fa-facebook-f"></i> تابعنا على فيسبوك
                </a>
                <a href="#" class="social-btn btn-instagram">
                    <i class="fab fa-instagram"></i> تابعنا على إنستجرام
                </a>
            </div>
            <p style="margin-top: 20px; font-size: 0.85rem; color: var(--color-text-muted);">
                فريق الدعم الفني متاح للرد على رسائلكم خلال دقائق
            </p>
        </div>
    </div>

    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6811.193051721169!2d31.77784890865427!3d31.39768691864596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1767559765018!5m2!1sar!2seg" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</div>
@endsection