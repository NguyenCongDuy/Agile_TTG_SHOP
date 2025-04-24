@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
    </nav>

    <h1 class="h2 mb-4">Shopping Cart</h1>

    @if(session('cart'))
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        @php
                            $total = 0;
                        @endphp
                        @foreach(session('cart') as $id => $details)
                            @php
                                $total += $details['price'] * $details['quantity'];
                            @endphp
                            <div id="cart-item-{{ $id }}" class="cart-item p-3 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-4 mb-2 mb-md-0">
                                        <img src="{{ $details['image'] ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop' }}" alt="{{ $details['name'] }}" class="cart-item-img img-fluid rounded">
                                    </div>
                                    <div class="col-md-4 col-8 mb-2 mb-md-0">
                                        <h5 class="mb-1">{{ $details['name'] }}</h5>
                                        <p class="text-muted small mb-0">SKU: {{ $details['sku'] ?? 'N/A' }}</p>
                                        @if(isset($details['variant']))
                                            <p class="text-muted small mb-0">{{ $details['variant'] }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-2 col-4 text-center mb-2 mb-md-0">
                                        <span class="price">${{ number_format($details['price'], 2) }}</span>
                                    </div>
                                    <div class="col-md-2 col-4 text-center mb-2 mb-md-0">
                                        <div class="input-group input-group-sm mx-auto" style="width: 100px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="decrease" data-id="{{ $id }}">-</button>
                                            <input type="text" class="form-control text-center quantity-input" value="{{ $details['quantity'] }}" data-id="{{ $id }}" min="1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="increase" data-id="{{ $id }}">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4 text-end mb-2 mb-md-0">
                                        <span class="fw-bold">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                                        <button type="button" class="btn btn-sm text-danger remove-item ms-2" data-id="{{ $id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('client.products') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button id="update-cart" class="btn btn-outline-success">
                        <i class="bi bi-arrow-clockwise me-2"></i>Update Cart
                    </button>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax</span>
                            <span>${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary" id="cart-total">${{ number_format($total * 1.1, 2) }}</span>
                        </div>

                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label for="coupon" class="form-label">Coupon Code</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="coupon" placeholder="Enter coupon code">
                                <button class="btn btn-outline-secondary" type="button">Apply</button>
                            </div>
                        </div>

                        <a href="{{ route('client.checkout') }}" class="btn btn-primary w-100">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">We Accept</h6>
                        <div class="d-flex justify-content-between">
                            <i class="bi bi-credit-card fs-2 text-primary"></i>
                            <i class="bi bi-paypal fs-2 text-primary"></i>
                            <i class="bi bi-wallet2 fs-2 text-primary"></i>
                            <i class="bi bi-bank fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-cart-x display-1 text-muted"></i>
            </div>
            <h3 class="text-muted mb-4">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('client.products') }}" class="btn btn-primary btn-lg">
                Start Shopping
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove item from cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const cartItem = document.getElementById('cart-item-' + id);

            fetch('{{ route("client.cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fade out and remove the item
                    cartItem.style.opacity = '0';
                    cartItem.style.transition = 'opacity 0.3s';

                    setTimeout(() => {
                        cartItem.remove();

                        // Update totals
                        document.getElementById('cart-subtotal').textContent = data.subtotal;
                        document.getElementById('cart-total').textContent = data.total;

                        // Update cart count in navbar if exists
                        const cartCount = document.querySelector('.cart-badge .badge');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }

                        // If cart is empty, reload page
                        if (data.cart_count == 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });

    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            let value = parseInt(input.value);

            if (action === 'increase') {
                input.value = value + 1;
            } else if (action === 'decrease') {
                if (value > 1) {
                    input.value = value - 1;
                }
            }
        });
    });

    // Quantity input validation
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            }
        });
    });

    // Update cart button
    document.getElementById('update-cart').addEventListener('click', function() {
        const updates = [];

        document.querySelectorAll('.quantity-input').forEach(input => {
            updates.push({
                id: input.getAttribute('data-id'),
                quantity: input.value
            });
        });

        fetch('{{ route("client.cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ updates: updates })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
});
</script>
@endpush
@endsection
