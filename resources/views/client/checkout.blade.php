@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.cart') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>

    <!-- Checkout Progress -->
    <div class="checkout-progress mb-5">
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="checkout-step active">
                <div class="step-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="step-text">Giỏ hàng</div>
            </div>
            <div class="checkout-step active">
                <div class="step-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="step-text">Thanh toán</div>
            </div>
            <div class="checkout-step">
                <div class="step-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="step-text">Hoàn tất</div>
            </div>
        </div>
    </div>

    <h1 class="h2 mb-4">Thanh toán đơn hàng</h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- Checkout Steps -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <ul class="nav nav-pills nav-fill" id="checkoutSteps" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="shipping-tab" data-bs-toggle="pill" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="true">
                                <i class="bi bi-geo-alt me-2"></i>
                                <span class="d-none d-md-inline">1. Thông tin giao hàng</span>
                                <span class="d-md-none">1</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="pill" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">
                                <i class="bi bi-credit-card me-2"></i>
                                <span class="d-none d-md-inline">2. Phương thức thanh toán</span>
                                <span class="d-md-none">2</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">
                                <i class="bi bi-check-circle me-2"></i>
                                <span class="d-none d-md-inline">3. Xác nhận đơn hàng</span>
                                <span class="d-md-none">3</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form id="checkoutForm" action="{{ route('client.checkout.store') }}" method="POST">
                        @csrf
                        <div class="tab-content" id="checkoutStepsContent">
                            <!-- Shipping Information -->
                            <div class="tab-pane fade show active" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                <h5 class="mb-4"><i class="bi bi-person-lines-fill me-2"></i>Thông tin giao hàng</h5>
                                <div class="alert alert-info mb-4">
                                    <i class="bi bi-info-circle me-2"></i> Vui lòng nhập đầy đủ thông tin giao hàng để chúng tôi có thể giao hàng đến bạn một cách nhanh chóng và chính xác.
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ đường phố</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="city" class="form-label">Thành phố</label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="state" class="form-label">Tỉnh/Thành phố</label>
                                        <input type="text" class="form-control" id="state" name="state" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="zip" class="form-label">Mã bưu điện</label>
                                        <input type="text" class="form-control" id="zip" name="zip" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ghi chú đơn hàng (Không bắt buộc)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Ghi chú về đơn hàng của bạn, ví dụ: hướng dẫn giao hàng"></textarea>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('client.cart') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại giỏ hàng
                                    </a>
                                    <button type="button" class="btn btn-primary next-step" data-next="payment-tab">Tiếp tục thanh toán<i class="bi bi-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                <h5 class="mb-4"><i class="bi bi-wallet2 me-2"></i>Phương thức thanh toán</h5>
                                <div class="alert alert-info mb-4">
                                    <i class="bi bi-info-circle me-2"></i> Chọn phương thức thanh toán phù hợp với bạn. Chúng tôi đảm bảo thông tin thanh toán của bạn luôn được bảo mật.
                                </div>
                                <div class="payment-methods">
                                    <div class="form-check mb-3 p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                                        <label class="form-check-label d-flex align-items-center" for="credit_card">
                                            <i class="bi bi-credit-card fs-4 me-3 text-primary"></i>
                                            <div>
                                                <span class="d-block fw-bold">Thẻ tín dụng/Ghi nợ</span>
                                                <small class="text-muted">Thanh toán an toàn bằng thẻ của bạn</small>
                                            </div>
                                        </label>
                                        <div class="mt-3 payment-details" id="credit_card_details" style="display: none;">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="card_number" class="form-label">Card Number</label>
                                                    <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                                    <input type="text" class="form-control" id="expiry_date" placeholder="MM/YY">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="cvv" class="form-label">CVV</label>
                                                    <input type="text" class="form-control" id="cvv" placeholder="123">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check mb-3 p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                        <label class="form-check-label d-flex align-items-center" for="paypal">
                                            <i class="bi bi-paypal fs-4 me-3 text-primary"></i>
                                            <div>
                                                <span class="d-block fw-bold">PayPal</span>
                                                <small class="text-muted">Thanh toán qua PayPal; bạn có thể thanh toán bằng thẻ tín dụng nếu không có tài khoản PayPal.</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3 p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                            <i class="bi bi-bank fs-4 me-3 text-primary"></i>
                                            <div>
                                                <span class="d-block fw-bold">Chuyển khoản ngân hàng</span>
                                                <small class="text-muted">Thanh toán trực tiếp vào tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng mã đơn hàng của bạn làm mã tham chiếu thanh toán.</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3 p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <label class="form-check-label d-flex align-items-center" for="cod">
                                            <i class="bi bi-cash-coin fs-4 me-3 text-primary"></i>
                                            <div>
                                                <span class="d-block fw-bold">Thanh toán khi nhận hàng</span>
                                                <small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng.</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="shipping-tab">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại thông tin giao hàng
                                    </button>
                                    <button type="button" class="btn btn-primary next-step" data-next="review-tab">Xem lại đơn hàng<i class="bi bi-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <!-- Order Review -->
                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                <h5 class="mb-4"><i class="bi bi-clipboard-check me-2"></i>Xác nhận đơn hàng của bạn</h5>
                                <div class="alert alert-success mb-4">
                                    <i class="bi bi-check-circle me-2"></i> Vui lòng kiểm tra lại thông tin đơn hàng trước khi xác nhận đặt hàng.
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="mb-2">Thông tin giao hàng</h6>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="mb-1"><span id="review-name">{{ auth()->user()->name }}</span></p>
                                                <p class="mb-1"><span id="review-address"></span></p>
                                                <p class="mb-1"><span id="review-city"></span>, <span id="review-state"></span> <span id="review-zip"></span></p>
                                                <p class="mb-1">Số điện thoại: <span id="review-phone"></span></p>
                                                <p class="mb-0">Email: <span id="review-email">{{ auth()->user()->email }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-2">Phương thức thanh toán</h6>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="mb-0" id="review-payment">Thanh toán khi nhận hàng</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th class="text-center">Giá</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-end">Tổng cộng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $subtotal = 0;
                                            @endphp
                                            @foreach(session('cart') as $id => $details)
                                                @php
                                                    $subtotal += $details['price'] * $details['quantity'];
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $details['image'] ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop' }}" alt="{{ $details['name'] }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                            <div>
                                                                <h6 class="mb-0">{{ $details['name'] }}</h6>
                                                                @if(isset($details['variant']))
                                                                    <small class="text-muted">{{ $details['variant'] }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ number_format($details['price'], 0, ',', '.') }}đ</td>
                                                    <td class="text-center">{{ $details['quantity'] }}</td>
                                                    <td class="text-end">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="payment-tab">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại thanh toán
                                    </button>
                                    <button type="button" class="btn btn-success btn-lg" id="placeOrderBtn" onclick="submitOrderForm()">
                                        <i class="bi bi-check-circle me-2"></i>Xác nhận đặt hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card shadow mb-4 checkout-summary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Tổng kết đơn hàng</h5>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = 0;
                        foreach(session('cart') as $id => $details) {
                            $subtotal += $details['price'] * $details['quantity'];
                        }
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $tax;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tổng tiền hàng</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Thuế (10%)</span>
                        <span>{{ number_format($tax, 0, ',', '.') }}đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="fw-bold fs-5">Tổng thanh toán</span>
                        <span class="fw-bold fs-5 text-success">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle me-2"></i> Đơn hàng sẽ được xử lý sau khi bạn xác nhận đặt hàng.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secure Checkout -->
            <div class="card shadow mb-4 border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Thanh toán an toàn</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Thông tin thanh toán của bạn được xử lý an toàn. Chúng tôi không lưu trữ thông tin thẻ tín dụng và không có quyền truy cập vào thông tin thẻ của bạn.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-center">
                            <i class="bi bi-shield-lock fs-2 text-success"></i>
                            <div class="small mt-1">Bảo mật</div>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-credit-card fs-2 text-primary"></i>
                            <div class="small mt-1">Thẻ tín dụng</div>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-paypal fs-2 text-primary"></i>
                            <div class="small mt-1">PayPal</div>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-bank fs-2 text-primary"></i>
                            <div class="small mt-1">Ngân hàng</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Need Help -->
            <div class="card shadow mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Cần hỗ trợ?</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="bi bi-telephone text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold">Gọi cho chúng tôi</p>
                            <p class="mb-0">+84 (123) 456-7890</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="bi bi-envelope text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold">Email hỗ trợ</p>
                            <p class="mb-0">hotro@example.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Checkout Progress */
    .checkout-progress .progress {
        margin-bottom: 15px;
    }

    .checkout-step {
        text-align: center;
        width: 33.333%;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border: 2px solid #dee2e6;
        font-size: 20px;
        color: #6c757d;
    }

    .checkout-step.active .step-icon {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .checkout-step.completed .step-icon {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    /* Payment Methods */
    .payment-methods .form-check {
        transition: all 0.3s ease;
    }

    .payment-methods .form-check:hover {
        background-color: #f8f9fa;
    }

    .payment-methods .form-check-input:checked + .form-check-label {
        font-weight: bold;
    }

    /* Order Summary */
    .checkout-summary {
        position: sticky;
        top: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
// Function to submit the order form
function submitOrderForm() {
    // Validate all required fields
    const form = document.getElementById('checkoutForm');
    const requiredFields = form.querySelectorAll('[required]');
    let allFieldsValid = true;

    // Check each required field
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            allFieldsValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Check if payment method is selected
    const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        alert('Vui lòng chọn phương thức thanh toán');
        allFieldsValid = false;
    }

    // If all fields are valid, submit the form
    if (allFieldsValid) {
        // Show loading indicator
        document.getElementById('placeOrderBtn').disabled = true;
        document.getElementById('placeOrderBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';

        // Submit the form
        form.submit();
    } else {
        // Show the shipping tab if there are validation errors
        document.getElementById('shipping-tab').click();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Navigation between checkout steps
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            const nextTab = this.getAttribute('data-next');
            document.getElementById(nextTab).click();

            // Update review information when going to review step
            if (nextTab === 'review-tab') {
                updateReviewInfo();
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function() {
            const prevTab = this.getAttribute('data-prev');
            document.getElementById(prevTab).click();
        });
    });



    // Payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all payment details first
            document.querySelectorAll('.payment-details').forEach(detail => {
                detail.style.display = 'none';
            });

            // Show the selected payment method details
            const detailsId = this.id + '_details';
            const details = document.getElementById(detailsId);
            if (details) {
                details.style.display = 'block';
            }
        });
    });

    // Update review information
    function updateReviewInfo() {
        document.getElementById('review-name').textContent = document.getElementById('name').value;
        document.getElementById('review-address').textContent = document.getElementById('address').value;
        document.getElementById('review-city').textContent = document.getElementById('city').value;
        document.getElementById('review-state').textContent = document.getElementById('state').value;
        document.getElementById('review-zip').textContent = document.getElementById('zip').value;
        document.getElementById('review-phone').textContent = document.getElementById('phone').value;
        document.getElementById('review-email').textContent = document.getElementById('email').value;

        // Update payment method
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        let paymentText = 'Thanh toán khi nhận hàng';

        if (selectedPayment.value === 'credit_card') {
            paymentText = 'Thẻ tín dụng/Ghi nợ';
        } else if (selectedPayment.value === 'paypal') {
            paymentText = 'PayPal';
        } else if (selectedPayment.value === 'bank_transfer') {
            paymentText = 'Chuyển khoản ngân hàng';
        } else {
            paymentText = 'Thanh toán khi nhận hàng';
        }

        document.getElementById('review-payment').textContent = paymentText;
    }
});
</script>
@endpush
@endsection