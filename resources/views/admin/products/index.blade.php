@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus"></i> Thêm sản phẩm
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Nổi bật</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productList as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 50px;">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    @if($product->is_featured)
                                        <span class="badge bg-success">Có</span>
                                    @else
                                        <span class="badge bg-secondary">Không</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->status)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $productList->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 