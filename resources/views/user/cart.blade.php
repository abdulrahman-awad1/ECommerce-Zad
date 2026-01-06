@extends('layouts.master')

@section('title', 'سلة التسوق')

@section('content')
<div class="cart-page-container">

    <h1 class="section-title">سلة التسوق</h1>

    @if(session('success'))
        <div class="cart-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($isEmpty)
        <div class="empty-cart">
            <i class="fas fa-shopping-basket"></i>
            <p>السلة فارغة حالياً</p>
            <a href="{{ route('home') }}">ابدأ التسوق الآن</a>
        </div>
    @else

        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                           
                            <img src="{{ $item->room->images->first()->image_path
    ? asset('images/uploads/' . $item->room->images->first()->image_path)
    : asset('images/no-image.jpg') }}"class="product-img">

                        </td>

                        <td>
                            <strong>{{ $item['room_name'] }}</strong>
                        </td>

                        <td>
                            <form
                                action="{{ route('cart.update') }}"
                                method="POST"
                                id="update-form-{{ $item['id'] }}"
                            >
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">

                                <div class="qty-stepper">
                                    <button type="button" onclick="autoStepQty({{ $item['id'] }}, -1)">−</button>

                                    <input
                                        type="number"
                                        id="qty-{{ $item['id'] }}"
                                        name="quantity"
                                        value="{{ $item['quantity'] }}"
                                        readonly
                                    >

                                    <button type="button" onclick="autoStepQty({{ $item['id'] }}, 1)">+</button>
                                </div>
                            </form>
                        </td>

                        <td>{{ number_format($item->room->price) }} ج.م</td>

                        <td class="highlight"> 
                            {{ number_format($item->room->price * $item->quantity) }} ج.م
                        </td>

                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">

                                <button class="btn-remove">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <span>الإجمالي الكلي</span>
            <strong>{{ number_format($total) }} ج.م</strong>

            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                إتمام الطلب
            </a>
        </div>

    @endif
</div>
@endsection

@push('scripts')
<script>
function autoStepQty(id, change) {
    const input = document.getElementById('qty-' + id);
    const form = document.getElementById('update-form-' + id);

    let value = parseInt(input.value) + change;

    if (value >= 1) {
        input.value = value;
        form.submit();
    }
}
</script>
@endpush
