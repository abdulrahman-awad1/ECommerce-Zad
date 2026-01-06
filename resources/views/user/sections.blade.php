@extends('layouts.master') @section('title', 'أقسام المتجر | زاد للأثاث') @section('content') <div class="page-header">
        <div class="container">
            <h1 class="section-heading">أقسام المتجر</h1>
            <p>تصفح تشكيلتنا الواسعة المصنفة بعناية</p>
        </div>
    </div>

    <section class="container">
        <div class="category-grid">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}">
                    <div class="category-card">
                        <i class="fas fa-layer-group" style="font-size: 2rem; color: var(--color-accent-gold); margin-bottom: 10px;"></i>
                        <div class="category-title">{{ $category->name }}</div>
                    </div>
                </a>
            @empty
                <p>لا توجد أقسام متاحة حالياً.</p>
            @endforelse
        </div>
    </section>
@endsection