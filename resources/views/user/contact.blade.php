@extends('layouts.master')

@push('styles')
<style>
    /* التخطيط الأساسي (Desktop) */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 30px;
    }
    .info-panel, .social-box {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        border: 1px solid #eee;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }
    .info-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: center;
    }
    .info-item i {
        font-size: 1.2rem;
        color: var(--color-gold);
        width: 30px;
    }
    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        color: #fff;
        transition: 0.3s;
    }
    .btn-whatsapp { background: #25D366; }
    .btn-facebook { background: #1877F2; }
    .btn-instagram { background: #E4405F; }
    
    .map-container {
        height: 400px;
        border-radius: 15px;
        overflow: hidden;
        margin-top: 40px;
        border: 1px solid #eee;
    }

    /* --- تعديلات الموبايل --- */
    @media (max-width: 768px) {
        .page-header-section h1 {
            font-size: 1.8rem !important; /* تصغير العنوان الضخم */
        }
        .page-header-section p {
            font-size: 0.9rem !important;
            padding: 0 15px;
        }
        
        .contact-grid {
            grid-template-columns: 1fr !important; /* تحويل الشبكة لعمود واحد */
            gap: 20px !important;
        }

        .info-panel, .social-box {
            padding: 20px !important; /* تقليل الحشو الداخلي */
        }

        .info-item h4 {
            font-size: 0.95rem !important;
        }

        .info-item p {
            font-size: 0.85rem !important;
        }

        .map-container {
            height: 300px !important; /* تقليل ارتفاع الخريطة */
            margin-top: 25px !important;
        }

        .social-btn {
            font-size: 0.9rem !important;
            padding: 10px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header-section" style="background: var(--color-bg); padding: 30px 0; text-align: center;">
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
                <a href="https://www.facebook.com/share/1AkxmSTaXo/" target="_blank" class="social-btn btn-facebook">
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
            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3411.365314050965!2d31.791552075505963!3d31.238320974343946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzHCsDE0JzE4LjAiTiAzMcKwNDcnMzguOSJF!5e0!3m2!1sen!2seg!4v1716294747424!5m2!1sen!2seg" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</div>
@endsection