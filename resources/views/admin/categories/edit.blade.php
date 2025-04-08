@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa danh mục</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="image">Hình ảnh</label>
                            @if($category->image)
                                <div class="mb-2">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">Danh mục nổi bật</label>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Trạng thái hoạt động</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 