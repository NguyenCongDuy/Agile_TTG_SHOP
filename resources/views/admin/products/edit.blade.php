@extends('layout.AdminLayout')

@section('content')
    <div class="container-fluid">
        <h2>Sửa sản phẩm: {{ $product->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description">Mô tả</label>
                <textarea name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label for="quantity">Số lượng</label>
                <input type="number" name="stock" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label for="category_id">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image">Hình ảnh</label><br>
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" alt="Hình ảnh" style="max-width: 100px; margin-bottom: 10px;"><br>
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-check mb-3">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured"
                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Nổi bật</label>
            </div>

            <div class="form-check mb-3">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" class="form-check-input" id="status"
                    {{ old('status', $product->status) ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Hiển thị</label>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
