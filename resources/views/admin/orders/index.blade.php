@extends('layout.AdminLayout')

@section('content')
<div class="app-main__inner">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Quản lý đơn hàng</h1>
            <p class="text-muted">Quản lý và theo dõi tất cả đơn hàng trong hệ thống</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.dashboard') }}" class="btn btn-primary">
                <i class="bi bi-speedometer2 me-1"></i> Tổng quan đơn hàng
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Lọc đơn hàng</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Trạng thái thanh toán</label>
                    <select name="payment_status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary"><i class="bi bi-list-ul me-2"></i>Danh sách đơn hàng</h5>
            <div class="text-muted">Tổng số: <span class="badge bg-primary">{{ $orders->total() }}</span></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
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
                                <td><strong class="text-primary">#{{ $order->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-text">{{ substr($order->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>{{ $order->user->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong class="text-success">{{ number_format($order->total_amount) }}đ</strong></td>
                                <td>
                                    <select class="form-select form-select-sm order-status" data-id="{{ $order->id }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                                <td>
                                    @if($order->payment)
                                        <select class="form-select form-select-sm payment-status" data-id="{{ $order->id }}">
                                            <option value="pending" {{ $order->payment->status == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                                            <option value="paid" {{ $order->payment->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                            <option value="unpaid" {{ $order->payment->status == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                        </select>
                                        <div class="spinner-border spinner-border-sm d-none" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    @else
                                        <span class="badge badge-secondary">Chưa có thông tin</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm delete-order" data-id="{{ $order->id }}" title="Xóa đơn hàng">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update order status
    $('.order-status').change(function() {
        var select = $(this);
        var spinner = select.next('.spinner-border');
        var orderId = select.data('id');
        var status = select.val();

        // Disable select and show spinner
        select.prop('disabled', true);
        spinner.removeClass('d-none');

        $.ajax({
            url: '/admin/orders/' + orderId + '/status',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: status
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Cập nhật trạng thái thành công');
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra');
                    // Revert to previous value on error
                    select.val(select.find('option[selected]').val());
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Có lỗi xảy ra, vui lòng thử lại');
                // Revert to previous value on error
                select.val(select.find('option[selected]').val());
            },
            complete: function() {
                // Re-enable select and hide spinner
                select.prop('disabled', false);
                spinner.addClass('d-none');
            }
        });
    });

    // Update payment status
    $('.payment-status').change(function() {
        var select = $(this);
        var spinner = select.next('.spinner-border');
        var orderId = select.data('id');
        var status = select.val();

        // Disable select and show spinner
        select.prop('disabled', true);
        spinner.removeClass('d-none');

        $.ajax({
            url: '/admin/orders/' + orderId + '/payment-status',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: status
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Cập nhật trạng thái thanh toán thành công');
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra');
                    // Revert to previous value on error
                    select.val(select.find('option[selected]').val());
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Có lỗi xảy ra, vui lòng thử lại');
                // Revert to previous value on error
                select.val(select.find('option[selected]').val());
            },
            complete: function() {
                // Re-enable select and hide spinner
                select.prop('disabled', false);
                spinner.addClass('d-none');
            }
        });
    });

    // Delete order
    $('.delete-order').click(function() {
        var button = $(this);
        var orderId = button.data('id');

        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
            button.prop('disabled', true);

            $.ajax({
                url: '/admin/orders/' + orderId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Xóa đơn hàng thành công');
                        button.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra');
                        button.prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Có lỗi xảy ra, vui lòng thử lại');
                    button.prop('disabled', false);
                }
            });
        }
    });
});
</script>
@endpush