@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Giỏ hàng</h1>

    @if(session('cart'))
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">Sản phẩm</th>
                                <th scope="col" class="text-center">Giá</th>
                                <th scope="col" class="text-center">Số lượng</th>
                                <th scope="col" class="text-center">Tổng</th>
                                <th scope="col" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach(session('cart') as $id => $details)
                                @php
                                    $total += $details['price'] * $details['quantity'];
                                @endphp
                                <tr id="cart-item-{{ $id }}">
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $details['name'] }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-primary">{{ number_format($details['price']) }}đ</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('client.cart.update', $id) }}" method="POST" class="d-flex justify-content-center">
                                            @csrf
                                            <div class="input-group" style="width: 120px;">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control text-center">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-success fw-bold">{{ number_format($details['price'] * $details['quantity']) }}đ</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-outline-danger remove-item" data-id="{{ $id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-center fw-bold text-success" id="cart-total">{{ number_format($total) }}đ</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('client.home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
            </a>
            <a href="{{ route('client.checkout') }}" class="btn btn-primary">
                Thanh toán<i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted mb-4">Giỏ hàng của bạn đang trống</h4>
            <a href="{{ route('client.home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.remove-item').click(function() {
        var id = $(this).data('id');
        var row = $('#cart-item-' + id);
        
        $.ajax({
            url: '{{ route("client.cart.remove") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                if (response.success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        $('#cart-total').text(response.total);
                        
                        // Update cart count in navbar if exists
                        if ($('#cart-count').length) {
                            $('#cart-count').text(response.cart_count);
                        }
                        
                        // If cart is empty, reload page
                        if (response.cart_count == 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại');
            }
        });
    });
});
</script>
@endpush
@endsection 