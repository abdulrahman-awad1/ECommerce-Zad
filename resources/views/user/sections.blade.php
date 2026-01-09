@extends('layouts.master')

@section('title', 'أقسام المتجر | زاد للأثاث')

@push('styles')
<style>
    /* تحسينات عامة للصفحة */
    .page-header {
        background: #fcfcfc;
        padding: 40px 0;
        text-align: center;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
    }

    .category-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }

    .category-card:hover {
        transform: translateY(-5px);
        border-color: var(--color-accent-gold);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .category-title {
        font-weight: bold;
        color: #333;
        font-size: 1.2rem;
    }

    /* --- تعديلات الموبايل (عنصرين بجانب بعض) --- */
    @media (max-width: 768px) {
        .page-header {
            padding: 25px 0 !important;
            margin-bottom: 20px !important;
        }
        .page-header h1 {
            font-size: 1.5rem !important;
        }
        .page-header p {
            font-size: 0.9rem !important;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr) !important; /* عنصرين بجانب بعض */
            gap: 12px !important;
            padding: 0 10px !important;
        }

        .category-card {
            padding: 20px 10px !important;
            border-radius: 12px !important;
        }

        .category-card i {
            font-size: 1.5rem !important; /* تصغير الأيقونة قليلاً */
        }

        .category-title {
            font-size: 0.95rem !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="section-heading">أقسام المتجر</h1>
            <p>تصفح تشكيلتنا الواسعة المصنفة بعناية</p>
        </div>
    </div>

    <section class="container">
        <div class="category-grid">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" style="text-decoration: none;">
                    <div class="category-card">
                        <i class="fas fa-layer-group" style="color: var(--color-accent-gold); margin-bottom: 10px;"></i>
                        <div class="category-title">{{ $category->name }}</div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                    <p>لا توجد أقسام متاحة حالياً.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection