@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Đơn hàng của tôi</h1>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('client.orders') }}" method="GET" class="row g-3" id="filter-form">
                <div class="col-md-4">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <select name="status" class="form-select filter-select">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trạng thái thanh toán</label>
                    <select name="payment_status" class="form-select filter-select">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sắp xếp theo</label>
                    <select name="sort" class="form-select filter-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-box-open fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted mb-4">Bạn chưa có đơn hàng nào</h4>
            <a href="{{ route('client.products') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total_amount) }}đ</td>
                            <td>
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
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <a href="{{ route('client.orders.detail', ['id' => $order->id]) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                @if($order->status === 'pending')
                                    <button class="btn btn-danger btn-sm cancel-order" data-id="{{ $order->id }}">
                                        <i class="fas fa-times"></i> Hủy đơn
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto submit form when select values change
        $('.filter-select').change(function() {
            $('#filter-form').submit();
        });

        // Cancel order functionality
        $('.cancel-order').click(function() {
            const orderId = $(this).data('id');

            if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                $.ajax({
                    url: `/client/orders/${orderId}/cancel`,
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