@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h1>
        <div class="d-flex gap-2">
            <!-- Confirm Reception Button/Form -->
            @if($order->status === \App\Models\Order::STATUS_DELIVERING)
                <form action="{{ route('client.orders.confirm', $order) }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Xác nhận đã nhận hàng
                    </button>
                </form>
            @endif

             <!-- Cancel Order Button/Form -->
            @if($order->status === \App\Models\Order::STATUS_PENDING)
                <form action="{{ route('client.orders.cancel', $order) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i>Hủy đơn hàng
                    </button>
                </form>
            @endif

            <a href="{{ route('client.orders') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại DS Đơn hàng
            </a>
        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="order-status-item {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'shipping' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="status-text">Chờ xử lý</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'processing' || $order->status == 'shipping' || $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'processing' || $order->status == 'shipping' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="status-text">Đang xử lý</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'shipping' || $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'shipping' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="status-text">Đang giao</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="status-text">Hoàn thành</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $detail->product->image }}" alt="{{ $detail->product->name }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0">{{ $detail->product->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">{{ number_format($detail->price) }}đ</td>
                                        <td class="text-end">{{ number_format($detail->price * $detail->quantity) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end text-primary fw-bold">{{ number_format($order->total_amount) }}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin đơn hàng</h5>
                    <div class="mb-3">
                        <label class="form-label text-muted">Trạng thái đơn hàng</label>
                        <div>
                            @switch($order->status)
                                @case(\App\Models\Order::STATUS_PENDING)
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                    @break
                                @case(\App\Models\Order::STATUS_PROCESSING)
                                    <span class="badge bg-info">Đang xử lý</span>
                                    @break
                                @case(\App\Models\Order::STATUS_DELIVERING)
                                    <span class="badge bg-primary">Đang giao</span>
                                    @break
                                @case(\App\Models\Order::STATUS_COMPLETED)
                                    <span class="badge bg-success">Hoàn thành</span>
                                    @break
                                @case(\App\Models\Order::STATUS_CANCELLED)
                                    <span class="badge bg-danger">Đã hủy</span>
                                    @break
                                @default
                                     <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Phương thức thanh toán</label>
                        <div>
                            @switch($order->payment_method)
                                @case('cod')
                                    <span class="badge bg-secondary">Thanh toán khi nhận hàng</span>
                                    @break
                                @case('bank_transfer')
                                    <span class="badge bg-secondary">Chuyển khoản ngân hàng</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Trạng thái thanh toán</label>
                        <div>
                            @if($order->payment || $order->payment_status)
                                @php
                                    $paymentStatus = $order->payment_status ?? ($order->payment ? $order->payment->status : null);
                                @endphp
                                @switch($paymentStatus)
                                    @case(\App\Models\Order::PAYMENT_PENDING)
                                        <span class="badge bg-warning">Chờ thanh toán</span>
                                        @break
                                    @case(\App\Models\Order::PAYMENT_PAID)
                                        <span class="badge bg-success">Đã thanh toán</span>
                                        @break
                                    @case(\App\Models\Order::PAYMENT_UNPAID)
                                        <span class="badge bg-danger">Chưa thanh toán</span>
                                        @break
                                     @default
                                        <span class="badge bg-secondary">{{ $paymentStatus }}</span>
                                @endswitch
                            @else
                                <span class="badge bg-secondary">Chưa có thông tin</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                    <div class="mb-3">
                        <label class="form-label text-muted">Họ và tên</label>
                        <div>{{ $order->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Số điện thoại</label>
                        <div>{{ $order->phone }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Địa chỉ giao hàng</label>
                        <div>{{ $order->shipping_address }}</div>
                    </div>
                    @if($order->notes)
                        <div class="mb-3">
                            <label class="form-label text-muted">Ghi chú</label>
                            <div>{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($order->status === 'completed' && !$order->rating)
    <!-- Rating Section -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Đánh giá đơn hàng</h5>
            <form id="rating-form">
                <div class="mb-3">
                    <label class="form-label">Đánh giá của bạn</label>
                    <div class="rating-stars mb-3">
                        <i class="fas fa-star rating-star" data-rating="1"></i>
                        <i class="fas fa-star rating-star" data-rating="2"></i>
                        <i class="fas fa-star rating-star" data-rating="3"></i>
                        <i class="fas fa-star rating-star" data-rating="4"></i>
                        <i class="fas fa-star rating-star" data-rating="5"></i>
                        <input type="hidden" name="rating" id="selected-rating" value="5">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Nhận xét (không bắt buộc)</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Chia sẻ ý kiến của bạn về đơn hàng này"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                </button>
            </form>
        </div>
    </div>
    @elseif($order->rating)
    <!-- Existing Rating -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Đánh giá của bạn</h5>
            <div class="d-flex align-items-center mb-3">
                <div class="me-2">
                    <span class="badge bg-primary rounded-pill p-2">{{ $order->rating->rating }}/5</span>
                </div>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $order->rating->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                </div>
            </div>
            @if($order->rating->comment)
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="card-text">{{ $order->rating->comment }}</p>
                        <small class="text-muted">{{ $order->rating->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    /* Order Status Timeline */
    .order-status-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 2px solid #dee2e6;
        font-size: 16px;
        color: #6c757d;
    }

    .order-status-item.active .status-icon {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .order-status-item.cancelled .status-icon {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .order-status-connector {
        flex-grow: 1;
        height: 3px;
        background-color: #dee2e6;
        margin-top: 20px;
    }

    .order-status-connector.active {
        background-color: #0d6efd;
    }

    /* Rating Stars */
    .rating-stars {
        font-size: 24px;
        color: #ccc;
    }

    .rating-stars .fa-star {
        cursor: pointer;
        margin-right: 5px;
    }

    .rating-stars .fa-star.active,
    .rating-stars .fa-star.text-warning {
        color: #ffc107;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Rating stars functionality
        $('.rating-star').hover(function() {
            var rating = $(this).data('rating');

            // Reset all stars
            $('.rating-star').removeClass('active');

            // Highlight stars up to the hovered one
            $('.rating-star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).addClass('active');
                }
            });
        });

        // Set initial rating (all stars active)
        $('.rating-star').addClass('active');

        // Handle click on stars
        $('.rating-star').click(function() {
            var rating = $(this).data('rating');
            $('#selected-rating').val(rating);

            // Update visual state
            $('.rating-star').removeClass('active');
            $('.rating-star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).addClass('active');
                }
            });
        });

        // Handle rating form submission
        $('#rating-form').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("client.orders.rate", ["order" => $order->id]) }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    rating: $('#selected-rating').val(),
                    comment: $('#comment').val()
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message || 'Có lỗi xảy ra');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert(response?.message || 'Có lỗi xảy ra');
                }
            });
        });

        // Handle order confirmation
        $('#confirm-order-btn').click(function() {
            if (confirm('Bạn xác nhận đã nhận được hàng?')) {
                $.ajax({
                    url: '{{ route("client.orders.confirm", ["order" => $order->id]) }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message || 'Có lỗi xảy ra');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        alert(response?.message || 'Có lỗi xảy ra');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection