@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Thông tin đơn hàng
                            </div>
                            <div class="mb-1">
                                <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="mb-1">
                                <strong>Trạng thái:</strong>
                                <span class="badge badge-{{ $order->status == 'completed' ? 'success' : 
                                    ($order->status == 'processing' ? 'info' : 
                                    ($order->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                    {{ $order->status == 'completed' ? 'Hoàn thành' : 
                                       ($order->status == 'processing' ? 'Đang xử lý' : 
                                       ($order->status == 'cancelled' ? 'Đã hủy' : 'Chờ xử lý')) }}
                                </span>
                            </div>
                            <div class="mb-1">
                                <strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }}đ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Thông tin khách hàng
                            </div>
                            <div class="mb-1">
                                <strong>Tên:</strong> {{ $order->user->name }}
                            </div>
                            <div class="mb-1">
                                <strong>Email:</strong> {{ $order->user->email }}
                            </div>
                            <div class="mb-1">
                                <strong>Địa chỉ:</strong> {{ $order->shipping_address }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Thông tin thanh toán
                            </div>
                            @if($order->payment)
                                <div class="mb-1">
                                    <strong>Trạng thái:</strong>
                                    <span class="badge badge-{{ $order->payment->status == 'paid' ? 'success' : 
                                        ($order->payment->status == 'unpaid' ? 'danger' : 'warning') }}">
                                        {{ $order->payment->status == 'paid' ? 'Đã thanh toán' : 
                                           ($order->payment->status == 'unpaid' ? 'Chưa thanh toán' : 'Chờ thanh toán') }}
                                    </span>
                                </div>
                                <div class="mb-1">
                                    <strong>Phương thức:</strong> {{ $order->payment->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}
                                </div>
                                <div class="mb-1">
                                    <strong>Số tiền:</strong> {{ number_format($order->payment->amount) }}đ
                                </div>
                            @else
                                <div class="text-muted">Chưa có thông tin thanh toán</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                            <td><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ghi chú</h6>
            </div>
            <div class="card-body">
                {{ $order->notes }}
            </div>
        </div>
    @endif
</div>
@endsection 