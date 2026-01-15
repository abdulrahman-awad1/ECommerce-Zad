@extends('layouts.master')

@push('styles')
<style>
    /* تنسيقات خاصة بصفحة النجاح */
    .success-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
        text-align: center;
        margin-top: 20px;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #f0fff4;
        color: #27ae60;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
    }

    .order-number-badge {
        background: var(--color-gold, #c5a059);
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: bold;
    }

    .registration-section {
        margin-top: 40px;
        text-align: right;
        border-top: 1px solid #eee;
        padding-top: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: var(--color-gold, #c5a059);
        outline: none;
    }

    .submit-btn {
        background: var(--color-gold, #c5a059);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: bold;
        width: 100%;
        cursor: pointer;
        transition: 0.3s;
        font-size: 1.1rem;
    }

    .submit-btn:hover {
        background: #b48f4a;
        transform: translateY(-2px);
    }

    /* التعديلات للموبايل */
    @media (max-width: 768px) {
        .page-container {
            margin: 20px auto !important;
            padding: 0 15px !important;
        }

        .success-card {
            padding: 25px 15px;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            font-size: 30px;
        }

        .section-title {
            font-size: 1.3rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-container" style="max-width: 800px; margin: 60px auto; padding: 0 20px;">

    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <h1 class="section-title" style="border-right: none; padding-right: 0; margin-bottom: 10px;">
            تم استلام طلبك بنجاح!
        </h1>
       

        {{-- نعرض الجزء ده فقط لو اليوزر مش مسجل دخول والكنترولر سمح بده --}}
        @if(session('show_registration') || !auth()->check())
            <div class="registration-section">
                <h3 style="color: #333; margin-bottom: 15px;">خطوة واحدة باقية..</h3>
                <p style="color: #777; margin-bottom: 25px;">
                    أنشئ حساباً ببياناتك المفضلة الآن لتتمكن من تتبع حالة الأوردر، والحصول على خصومات حصرية لعملائنا المسجلين.
                </p>

                @if($errors->orderRegistrationBag->any())
                    <div class="alert alert-danger" style="background: #fff5f5; color: #c53030; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <ul style="margin: 0;">
                            @foreach ($errors->orderRegistrationBag->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('order.registration', ['order' => $order->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>الاسم الكامل</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="مثال: محمد أحمد">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="name@example.com">
                            </div>
                        </div>
                    </div>

                   

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>كلمة المرور</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-user-plus" style="margin-left: 10px;"></i> 
                        إنشاء حسابي ومتابعة الطلب
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="/" style="color: #999; text-decoration: none; font-size: 0.9rem;">
                        لا أرغب في إنشاء حساب الآن، العودة للرئيسية
                    </a>
                </div>
            </div>
        @else
            <div style="margin-top: 30px;">
                <a href="{{ route('user.orders') }}" class="submit-btn" style="text-decoration: none; display: inline-block;">
                    انتقل إلى طلباتي
                </a>
            </div>
        @endif
    </div>
</div>
@endsection