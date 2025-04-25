@extends('layout.AdminLayout')

@section('content')
<div class="app-main__inner">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng <span class="text-primary">#{{ $order->id }}</span></h1>
            <p class="text-muted">Ngày tạo: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            
            <!-- Status Update Form -->
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline-block">
                @csrf
                <div class="input-group">
                    <select name="status" class="form-select" id="order-status-select">
                        <option value="{{ App\Models\Order::STATUS_PENDING }}" 
                                {{ $order->status == App\Models\Order::STATUS_PENDING ? 'selected' : '' }} 
                                @if(in_array($order->status, [App\Models\Order::STATUS_PROCESSING, App\Models\Order::STATUS_DELIVERING, App\Models\Order::STATUS_COMPLETED, App\Models\Order::STATUS_CANCELLED])) disabled @endif>Chờ xử lý</option>
                                
                        <option value="{{ App\Models\Order::STATUS_PROCESSING }}" 
                                {{ $order->status == App\Models\Order::STATUS_PROCESSING ? 'selected' : '' }} 
                                @if(in_array($order->status, [App\Models\Order::STATUS_DELIVERING, App\Models\Order::STATUS_COMPLETED, App\Models\Order::STATUS_CANCELLED])) disabled @endif>Đang xử lý</option>
                                
                        <option value="{{ App\Models\Order::STATUS_DELIVERING }}" 
                                {{ $order->status == App\Models\Order::STATUS_DELIVERING ? 'selected' : '' }} 
                                @if(in_array($order->status, [App\Models\Order::STATUS_COMPLETED, App\Models\Order::STATUS_CANCELLED])) disabled @endif>Đang giao</option>
                                
                        <option value="{{ App\Models\Order::STATUS_CANCELLED }}" 
                                {{ $order->status == App\Models\Order::STATUS_CANCELLED ? 'selected' : '' }} 
                                @if(in_array($order->status, [App\Models\Order::STATUS_COMPLETED, App\Models\Order::STATUS_CANCELLED])) disabled @endif>Hủy đơn hàng</option>
                                
                        <!-- Admin cannot directly set to completed, always show as disabled if completed -->
                        @if($order->status == App\Models\Order::STATUS_COMPLETED)
                            <option value="{{ App\Models\Order::STATUS_COMPLETED }}" selected disabled>Đã hoàn thành</option>
                        @endif
                    </select>
                    <button type="submit" class="btn btn-primary" 
                            @if(in_array($order->status, [App\Models\Order::STATUS_COMPLETED, App\Models\Order::STATUS_CANCELLED])) disabled @endif>
                        Cập nhật TT
                    </button>
                </div>
            </form>

            <!-- Optional: Print button or other actions -->
             <a class="btn btn-outline-info" href="#" id="printOrder">
                <i class="bi bi-printer"></i> In
            </a>

        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="order-status-item {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="status-text">Chờ xử lý</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'processing' || $order->status == 'shipping' || $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'processing' || $order->status == 'shipping' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="status-text">Đang xử lý</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'shipping' || $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'shipping' || $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="status-text">Đang giao</div>
                </div>
                <div class="order-status-connector {{ $order->status == 'completed' ? 'active' : '' }}"></div>
                <div class="order-status-item {{ $order->status == 'completed' ? 'active' : ($order->status == 'cancelled' ? 'cancelled' : '') }}">
                    <div class="status-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="status-text">Hoàn thành</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted d-block">Mã đơn hàng:</label>
                        <span class="fw-bold">#{{ $order->id }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Ngày đặt hàng:</label>
                        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Trạng thái:</label>
                        <span class="badge bg-{{ $order->status == \App\Models\Order::STATUS_COMPLETED ? 'success' :
                            ($order->status == \App\Models\Order::STATUS_PROCESSING ? 'info' :
                            ($order->status == \App\Models\Order::STATUS_DELIVERING ? 'primary' :
                            ($order->status == \App\Models\Order::STATUS_CANCELLED ? 'danger' : 'warning'))) }}">
                            {{ $order->status == \App\Models\Order::STATUS_COMPLETED ? 'Hoàn thành' :
                               ($order->status == \App\Models\Order::STATUS_PROCESSING ? 'Đang xử lý' :
                               ($order->status == \App\Models\Order::STATUS_DELIVERING ? 'Đang giao' :
                               ($order->status == \App\Models\Order::STATUS_CANCELLED ? 'Đã hủy' :
                               ($order->status == \App\Models\Order::STATUS_PENDING ? 'Chờ xử lý' : $order->status)))) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Tổng tiền:</label>
                        <span class="fw-bold text-success">{{ number_format($order->total_amount) }}đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md bg-light rounded-circle me-3">
                            <span class="avatar-text">{{ substr($order->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $order->user->name }}</h6>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Số điện thoại:</label>
                        <span>{{ $order->phone }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Địa chỉ giao hàng:</label>
                        <span>{{ $order->shipping_address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Thông tin thanh toán</h5>
                </div>
                <div class="card-body">
                    @if($order->payment)
                        <div class="mb-3">
                            <label class="text-muted d-block">Trạng thái thanh toán:</label>
                            <span class="badge bg-{{ $order->payment_status == \App\Models\Order::PAYMENT_PAID ? 'success' :
                                ($order->payment_status == \App\Models\Order::PAYMENT_UNPAID ? 'danger' : 'warning') }}">
                                {{ $order->payment_status == \App\Models\Order::PAYMENT_PAID ? 'Đã thanh toán' :
                                   ($order->payment_status == \App\Models\Order::PAYMENT_UNPAID ? 'Chưa thanh toán' :
                                   ($order->payment_status == \App\Models\Order::PAYMENT_PENDING ? 'Chờ thanh toán' : $order->payment_status)) }} 
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block">Phương thức thanh toán:</label>
                            <div class="d-flex align-items-center">
                                <i class="bi {{ $order->payment_method == 'cod' ? 'bi-cash' : 'bi-bank' }} me-2"></i>
                                <span>{{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block">Số tiền thanh toán:</label>
                            <span class="fw-bold text-success">{{ number_format($order->payment->amount) }}đ</span>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Chưa có thông tin thanh toán
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary"><i class="bi bi-box2 me-2"></i>Danh sách sản phẩm</h5>
            <span class="badge bg-primary">{{ count($order->orderDetails) }} sản phẩm</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="45%">Sản phẩm</th>
                            <th width="15%">Giá</th>
                            <th width="15%">Số lượng</th>
                            <th width="20%">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="product-thumbnail me-3">
                                        @else
                                            <div class="product-thumbnail-placeholder me-3"><i class="bi bi-image"></i></div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'Không có danh mục' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong class="text-success">{{ number_format($item->price * $item->quantity) }}đ</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong class="text-success fs-5">{{ number_format($order->total_amount) }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes)
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="bi bi-sticky me-2"></i>Ghi chú</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <i class="bi bi-quote me-2"></i>
                    {{ $order->notes }}
                </div>
            </div>
        </div>
    @endif

    <!-- Order Rating -->
    @if($order->rating)
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="bi bi-star me-2"></i>Đánh giá từ khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <span class="badge bg-primary rounded-pill p-2 fs-6">{{ $order->rating->rating }}/5</span>
                    </div>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star-fill {{ $i <= $order->rating->rating ? 'text-warning' : 'text-muted' }} me-1" style="font-size: 1.2rem;"></i>
                        @endfor
                    </div>
                    <div class="ms-auto text-muted">
                        <small>{{ $order->rating->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                @if($order->rating->comment)
                    <div class="alert alert-light">
                        <i class="bi bi-quote me-2"></i>
                        {{ $order->rating->comment }}
                    </div>
                @else
                    <p class="text-muted fst-italic">Khách hàng không để lại nhận xét.</p>
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
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 2px solid #dee2e6;
        font-size: 20px;
        color: #6c757d;
    }

    .order-status-item.active .status-icon {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }

    .order-status-item.cancelled .status-icon {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: white;
    }

    .order-status-connector {
        flex-grow: 1;
        height: 4px;
        background-color: #dee2e6;
        margin-top: 25px;
    }

    .order-status-connector.active {
        background-color: #4e73df;
    }

    /* Product Thumbnail */
    .product-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    .product-thumbnail-placeholder {
        width: 50px;
        height: 50px;
        background-color: #f8f9fa;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }

    /* Avatar */
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
    }

    .avatar-md {
        width: 50px;
        height: 50px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Print order
    $('#printOrder').click(function(e) {
        e.preventDefault();
        window.print();
    });
});
</script>
@endpush
</div>
@endsection
