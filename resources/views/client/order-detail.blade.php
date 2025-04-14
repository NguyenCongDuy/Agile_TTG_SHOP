@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('client.orders') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
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
                                @case('pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                    @break
                                @case('processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                    @break
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
                            @if($order->payment)
                                @switch($order->payment->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Chờ thanh toán</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                        @break
                                    @case('unpaid')
                                        <span class="badge bg-danger">Chưa thanh toán</span>
                                        @break
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
</div>
@endsection 