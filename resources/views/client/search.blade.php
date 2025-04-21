@extends('layout.ClientLayout')

@section('title', 'Kết quả tìm kiếm: ' . $query)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tìm kiếm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <!-- Search Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Kết quả tìm kiếm</h5>
                    <p class="card-text">Từ khóa: <strong>{{ $query }}</strong></p>
                    <p class="card-text">Tìm thấy {{ $products->total() }} sản phẩm</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Bộ lọc</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.search') }}" method="GET">
                        <input type="hidden" name="q" value="{{ $query }}">
                        
                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="d-flex align-items-center">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Từ" value="{{ request('min_price') }}">
                                <span class="mx-2">-</span>
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Đến" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tình trạng</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="availability" value="in_stock" id="inStock" {{ request('availability') == 'in_stock' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inStock">
                                    Còn hàng
                                </label>
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sắp xếp theo</label>
                            <select name="sort_by" class="form-select form-select-sm">
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                                <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100">Áp dụng</button>
                    </form>
                </div>
            </div>

            <!-- Popular Categories -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Danh mục phổ biến</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach(\App\Models\Category::where('is_featured', true)->take(5)->get() as $category)
                        <li class="list-group-item px-0">
                            <a href="{{ route('client.category', $category->slug) }}" class="text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Kết quả tìm kiếm: {{ $query }}</h2>
                <span class="text-muted">Hiển thị {{ $products->count() }} / {{ $products->total() }} sản phẩm</span>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $query }}".
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card card h-100 shadow-sm border-0 position-relative">
                            <div class="product-badges position-absolute top-0 start-0 p-2 z-1">
                                @if($product->is_featured)
                                    <span class="badge bg-danger mb-1 d-block">Nổi bật</span>
                                @endif
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    @php
                                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                    @endphp
                                    <span class="badge bg-success d-block">-{{ $discount }}%</span>
                                @endif
                            </div>
                            <div class="product-img-wrapper overflow-hidden">
                                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1587202372583-49330a15584d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80' }}" 
                                     class="card-img-top product-img" alt="{{ $product->name }}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="product-info mb-auto">
                                    <p class="product-category text-muted small mb-1">
                                        <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                    </p>
                                    <h5 class="product-title card-title text-truncate mb-2">{{ $product->name }}</h5>
                                    <div class="product-rating mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                        <span class="rating-count text-muted small ms-1">({{ rand(10, 50) }})</span>
                                    </div>
                                    <div class="product-price mb-2">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="current-price fw-bold">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                            <span class="original-price text-muted text-decoration-line-through ms-2">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                        @else
                                            <span class="current-price fw-bold">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                        @endif
                                    </div>
                                    @if($product->stock <= 0)
                                        <p class="stock-status text-danger small mb-0">
                                            <i class="bi bi-x-circle me-1"></i>Hết hàng
                                        </p>
                                    @elseif($product->stock < 5)
                                        <p class="stock-status text-warning small mb-0">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Chỉ còn {{ $product->stock }} sản phẩm
                                        </p>
                                    @else
                                        <p class="stock-status text-success small mb-0">
                                            <i class="bi bi-check-circle me-1"></i>Còn hàng
                                        </p>
                                    @endif
                                </div>
                                <div class="product-actions mt-3 d-flex">
                                    <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline me-2 flex-grow-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary w-100" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                        </button>
                                    </form>
                                    <a href="{{ route('client.product', $product->slug) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Product Card Styles */
    .product-img-wrapper {
        height: 200px;
        overflow: hidden;
    }
    
    .product-img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    
    .original-price {
        font-size: 0.9rem;
    }
    
    /* Pagination Styling */
    .pagination {
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-active-border-color: #0d6efd;
    }
</style>
@endpush
@endsection
