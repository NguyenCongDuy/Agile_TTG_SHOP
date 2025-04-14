@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 500px; object-fit: cover;">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="h2 mb-4">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center mb-4">
                <span class="h3 text-primary me-3">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @if($product->stock > 0)
                    <span class="badge bg-success">Còn hàng ({{ $product->stock }})</span>
                @else
                    <span class="badge bg-danger">Hết hàng</span>
                @endif
            </div>

            <div class="mb-4">
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            <div class="mb-4">
                <form action="{{ route('client.cart.add') }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group me-3" style="width: 150px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        Thêm vào giỏ
                    </button>
                </form>
            </div>

            <div class="border-top pt-4">
                <h2 class="h5 mb-3">Danh mục</h2>
                <a href="{{ route('client.category', $product->category->slug) }}" class="text-decoration-none">
                    {{ $product->category->name }}
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h2 class="h3 mb-4">Sản phẩm liên quan</h2>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <a href="{{ route('client.product', $relatedProduct->slug) }}" class="text-decoration-none">
                        <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h3 class="card-title h6 text-dark">{{ $relatedProduct->name }}</h3>
                            <p class="card-text text-primary fw-bold">{{ number_format($relatedProduct->price, 0, ',', '.') }}đ</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
function increaseQuantity() {
    const input = document.querySelector('input[name="quantity"]');
    const max = parseInt(input.getAttribute('max'));
    let value = parseInt(input.value);
    if (value < max) {
        input.value = value + 1;
    }
}

function decreaseQuantity() {
    const input = document.querySelector('input[name="quantity"]');
    let value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
    }
}
</script>
@endsection 