@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Thanh toán</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin giao hàng</h5>
                    <form action="{{ route('client.checkout.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>

                        <h5 class="card-title mb-4">Phương thức thanh toán</h5>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                <label class="form-check-label" for="bank_transfer">
                                    Chuyển khoản ngân hàng
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Đơn hàng của bạn</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach(session('cart') as $id => $details)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0">{{ $details['name'] }}</h6>
                                                    <small class="text-muted">x{{ $details['quantity'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">{{ number_format($details['price'] * $details['quantity']) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tổng cộng:</th>
                                    <td class="text-end text-primary fw-bold">{{ number_format($total) }}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 