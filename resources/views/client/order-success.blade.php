@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.cart') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.checkout') }}">Thanh toán</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đặt hàng thành công</li>
        </ol>
    </nav>

    <!-- Checkout Progress -->
    <div class="checkout-progress mb-5">
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="checkout-step completed">
                <div class="step-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="step-text">Giỏ hàng</div>
            </div>
            <div class="checkout-step completed">
                <div class="step-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="step-text">Thanh toán</div>
            </div>
            <div class="checkout-step completed">
                <div class="step-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="step-text">Hoàn tất</div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-5 border-success">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="h3 mb-3 text-success">Đặt hàng thành công!</h1>
                    <p class="mb-4">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận và đang được xử lý.</p>
                    
                    <div class="alert alert-light mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="bi bi-receipt fs-1 text-primary"></i>
                            </div>
                            <div class="text-start">
                                <h5 class="mb-1">Mã đơn hàng: <strong>#{{ $order->id }}</strong></h5>
                                <p class="mb-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-start">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6>Thông tin giao hàng:</h6>
                                <p class="mb-1">{{ $order->name }}</p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">Điện thoại: {{ $order->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Thông tin thanh toán:</h6>
                                <p class="mb-1">
                                    <span class="badge bg-{{ $order->payment && $order->payment->status == 'paid' ? 'success' : 'warning' }}">
                                        {{ $order->payment && $order->payment->status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                    </span>
                                </p>
                                <p class="mb-1">Phương thức: 
                                    @if($order->payment_method == 'cod')
                                        Thanh toán khi nhận hàng
                                    @elseif($order->payment_method == 'bank_transfer')
                                        Chuyển khoản ngân hàng
                                    @elseif($order->payment_method == 'credit_card')
                                        Thẻ tín dụng/Ghi nợ
                                    @else
                                        PayPal
                                    @endif
                                </p>
                                <p class="mb-1">Tổng tiền: <strong class="text-success">{{ number_format($order->total_amount) }}đ</strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('client.orders.detail', $order->id) }}" class="btn btn-primary">
                            <i class="bi bi-eye me-2"></i>Xem chi tiết đơn hàng
                        </a>
                        <a href="{{ route('client.products') }}" class="btn btn-outline-primary">
                            <i class="bi bi-shop me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- What's Next -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Các bước tiếp theo</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="text-center">
                                <div class="bg-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="bi bi-envelope-check fs-2 text-primary"></i>
                                </div>
                                <h6>Xác nhận qua email</h6>
                                <p class="small">Bạn sẽ nhận được email xác nhận đơn hàng với đầy đủ thông tin chi tiết.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="text-center">
                                <div class="bg-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="bi bi-box-seam fs-2 text-primary"></i>
                                </div>
                                <h6>Chuẩn bị đơn hàng</h6>
                                <p class="small">Chúng tôi sẽ chuẩn bị đơn hàng của bạn và thông báo khi đơn hàng được giao cho đơn vị vận chuyển.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="bg-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="bi bi-truck fs-2 text-primary"></i>
                                </div>
                                <h6>Giao hàng</h6>
                                <p class="small">Đơn hàng sẽ được giao đến địa chỉ của bạn trong thời gian sớm nhất.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Need Help -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Cần hỗ trợ?</h5>
                </div>
                <div class="card-body">
                    <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi:</p>
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="bi bi-telephone text-primary fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold">Gọi cho chúng tôi</p>
                                    <p class="mb-0">+84 (123) 456-7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
</style>
@endpush
@endsection
