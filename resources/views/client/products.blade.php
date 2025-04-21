@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <h1 class="h2 mb-4 text-center d-md-none">Sản phẩm</h1>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.products') }}" method="GET">
                        <!-- Categories -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Danh mục</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="all" id="category-all" checked>
                                <label class="form-check-label" for="category-all">
                                    Tất cả danh mục
                                </label>
                            </div>

                            <!-- PC Categories -->
                            <div class="mb-2 mt-3">
                                <strong class="small text-uppercase">Máy tính</strong>
                            </div>
                            @foreach($categories ?? [] as $category)
                                @if(in_array($category->name, ['PC Gaming', 'PC Văn Phòng', 'PC Core Ultra', 'PC Mini']))
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}">
                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endif
                            @endforeach

                            <!-- Components Categories -->
                            <div class="mb-2 mt-3">
                                <strong class="small text-uppercase">Linh kiện</strong>
                            </div>
                            @foreach($categories ?? [] as $category)
                                @if(!in_array($category->name, ['PC Gaming', 'PC Văn Phòng', 'PC Core Ultra', 'PC Mini']))
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}">
                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Price Range Slider -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Khoảng giá</h6>
                            <div class="price-range-slider">
                                <div class="range-slider mb-3">
                                    <input type="range" class="form-range" id="price-range" min="0" max="50000000" step="1000000">
                                </div>
                                <div class="price-inputs">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price-display">
                                            <span id="min-price-display">0đ</span> - <span id="max-price-display">50.000.000đ</span>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="reset-price-range">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </div>
                                    <!-- Hidden inputs to store the actual values -->
                                    <input type="hidden" id="min-price" name="min_price" value="0">
                                    <input type="hidden" id="max-price" name="max_price" value="50000000">
                                </div>
                            </div>
                        </div>

                        <!-- CPU Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">CPU</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="cpu[]" value="intel_i3" id="cpu-intel-i3">
                                <label class="form-check-label" for="cpu-intel-i3">
                                    Intel Core i3
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="cpu[]" value="intel_i5" id="cpu-intel-i5">
                                <label class="form-check-label" for="cpu-intel-i5">
                                    Intel Core i5
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="cpu[]" value="intel_i7" id="cpu-intel-i7">
                                <label class="form-check-label" for="cpu-intel-i7">
                                    Intel Core i7
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="cpu[]" value="intel_i9" id="cpu-intel-i9">
                                <label class="form-check-label" for="cpu-intel-i9">
                                    Intel Core i9
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="cpu[]" value="amd_ryzen" id="cpu-amd-ryzen">
                                <label class="form-check-label" for="cpu-amd-ryzen">
                                    AMD Ryzen
                                </label>
                            </div>
                        </div>

                        <!-- RAM Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">RAM</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ram[]" value="8gb" id="ram-8gb">
                                <label class="form-check-label" for="ram-8gb">
                                    8GB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ram[]" value="16gb" id="ram-16gb">
                                <label class="form-check-label" for="ram-16gb">
                                    16GB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ram[]" value="32gb" id="ram-32gb">
                                <label class="form-check-label" for="ram-32gb">
                                    32GB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ram[]" value="64gb" id="ram-64gb">
                                <label class="form-check-label" for="ram-64gb">
                                    64GB
                                </label>
                            </div>
                        </div>

                        <!-- SSD Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">SSD</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ssd[]" value="256gb" id="ssd-256gb">
                                <label class="form-check-label" for="ssd-256gb">
                                    256GB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ssd[]" value="512gb" id="ssd-512gb">
                                <label class="form-check-label" for="ssd-512gb">
                                    512GB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ssd[]" value="1tb" id="ssd-1tb">
                                <label class="form-check-label" for="ssd-1tb">
                                    1TB
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ssd[]" value="2tb" id="ssd-2tb">
                                <label class="form-check-label" for="ssd-2tb">
                                    2TB
                                </label>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Tình trạng</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="availability" value="all" id="availability-all" checked>
                                <label class="form-check-label" for="availability-all">
                                    Tất cả sản phẩm
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="availability" value="in_stock" id="availability-in-stock">
                                <label class="form-check-label" for="availability-in-stock">
                                    Còn hàng
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Lọc sản phẩm</button>
                    </form>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Sản phẩm nổi bật</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($featuredProducts ?? [] as $featuredProduct)
                        <li class="list-group-item">
                            <a href="{{ route('client.product', $featuredProduct->slug) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($featuredProduct->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}" alt="{{ $featuredProduct->name }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 text-truncate text-dark">{{ $featuredProduct->name }}</h6>
                                        <span class="text-primary">{{ number_format($featuredProduct->price, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product Listings -->
        <div class="col-lg-9">
            <!-- Sorting and Display Options -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} của {{ $products->total() ?? 0 }} sản phẩm</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="sort-by" class="me-2 mb-0">Sắp xếp theo:</label>
                            <select class="form-select form-select-sm" id="sort-by" name="sort_by" onchange="this.form.submit()">
                                <option value="newest">Mới nhất</option>
                                <option value="price_low">Giá: Thấp đến cao</option>
                                <option value="price_high">Giá: Cao đến thấp</option>
                                <option value="name_asc">Tên: A-Z</option>
                                <option value="name_desc">Tên: Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row">
                @forelse($products as $product)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="product-card card h-100">
                        <div class="position-relative">
                            <img src="{{ asset($product->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}" class="card-img-top" alt="{{ $product->name }}">
                            @if($product->is_featured)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Featured</span>
                            @endif
                            @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">Sale</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text text-muted small mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                                        <span class="price">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                        <span class="original-price ms-2">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-outline-primary" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                        </button>
                                    </form>
                                    <a href="{{ route('client.product', $product->slug) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                                </div>
                                @if($product->stock <= 0)
                                    <p class="text-danger mb-0 small mt-2">Hết hàng</p>
                                @elseif($product->stock < 5)
                                    <p class="text-warning mb-0 small mt-2">Chỉ còn {{ $product->stock }} sản phẩm</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-exclamation-circle me-2"></i>Không tìm thấy sản phẩm nào. Vui lòng thử lại với bộ lọc khác.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Price Range Slider
        const priceRangeSlider = document.getElementById('price-range');
        const minPriceDisplay = document.getElementById('min-price-display');
        const maxPriceDisplay = document.getElementById('max-price-display');
        const minPriceInput = document.getElementById('min-price');
        const maxPriceInput = document.getElementById('max-price');
        const resetPriceRangeBtn = document.getElementById('reset-price-range');

        // Default values
        const minPrice = 0;
        const maxPrice = 50000000;
        let currentValue = maxPrice;

        // Format price as Vietnamese currency
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
        }

        // Update price display and hidden inputs
        function updatePriceDisplay(value) {
            currentValue = value;
            minPriceDisplay.textContent = formatPrice(minPrice);
            maxPriceDisplay.textContent = formatPrice(value);
            minPriceInput.value = minPrice;
            maxPriceInput.value = value;
        }

        // Initialize with default values
        updatePriceDisplay(maxPrice);

        // Handle slider input
        priceRangeSlider.addEventListener('input', function() {
            updatePriceDisplay(this.value);
        });

        // Reset price range
        resetPriceRangeBtn.addEventListener('click', function() {
            priceRangeSlider.value = maxPrice;
            updatePriceDisplay(maxPrice);
        });

        // Set initial value from URL params if available
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('max_price')) {
            const urlMaxPrice = parseInt(urlParams.get('max_price'));
            if (!isNaN(urlMaxPrice) && urlMaxPrice >= minPrice && urlMaxPrice <= maxPrice) {
                priceRangeSlider.value = urlMaxPrice;
                updatePriceDisplay(urlMaxPrice);
            }
        }
    });
</script>
@endpush
