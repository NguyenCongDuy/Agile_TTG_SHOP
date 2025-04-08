@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết sản phẩm: {{ $product->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <span class="text-muted">Không có ảnh</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Giá</th>
                                    <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <th>Số lượng</th>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>{!! nl2br(e($product->description)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Nổi bật</th>
                                    <td>
                                        @if($product->is_featured)
                                            <span class="badge bg-success">Có</span>
                                        @else
                                            <span class="badge bg-secondary">Không</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($product->status)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày cập nhật</th>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 