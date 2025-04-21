@extends('layout.ClientLayout')

@section('title', 'TTG Shop - Máy tính & Linh kiện cao cấp')

@section('content')
{{-- @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif --}}

<!-- Hero Carousel -->
<div id="homeCarousel" class="carousel slide carousel-fade home-carousel mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner rounded shadow">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1742&q=80" class="d-block w-100" alt="Gaming PC Setup">
            <div class="carousel-caption">
                <div class="carousel-content">
                    <h1 class="display-4 fw-bold">Gaming PC Cao Cấp</h1>
                    <p class="lead">Trải nghiệm chơi game đỉnh cao với bộ PC Gaming hiệu năng mạnh mẽ</p>
                    <div class="mt-4">
                        <a href="{{ route('client.category', 'gaming-pc') }}" class="btn btn-primary btn-lg me-2">Khám phá ngay</a>
                        <a href="{{ route('client.products') }}" class="btn btn-outline-light btn-lg">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1591405351990-4726e331f141?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" class="d-block w-100" alt="PC Components">
            <div class="carousel-caption">
                <div class="carousel-content">
                    <h1 class="display-4 fw-bold">Linh Kiện Chính Hãng</h1>
                    <p class="lead">Đa dạng linh kiện cao cấp từ các thương hiệu uy tín hàng đầu</p>
                    <div class="mt-4">
                        <a href="{{ route('client.category', 'components') }}" class="btn btn-primary btn-lg me-2">Mua ngay</a>
                        <a href="{{ route('client.products') }}" class="btn btn-outline-light btn-lg">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1624705002806-5d72df19c3ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" class="d-block w-100" alt="Special Offers">
            <div class="carousel-caption">
                <div class="carousel-content">
                    <h1 class="display-4 fw-bold">Khuyến Mãi Đặc Biệt</h1>
                    <p class="lead">Giảm giá lên đến 30% cho các sản phẩm cao cấp</p>
                    <div class="mt-4">
                        <a href="{{ route('client.products') }}" class="btn btn-danger btn-lg me-2">Mua ngay</a>
                        <a href="{{ route('client.products') }}" class="btn btn-outline-light btn-lg">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container">

    <!-- Featured Categories -->
    <section class="featured-categories mb-5">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Danh mục nổi bật</h2>
            <a href="{{ route('client.products') }}" class="btn btn-outline-primary">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($categories->take(6) as $category)
            <div class="col-lg-4 col-md-6">
                <div class="category-card rounded shadow overflow-hidden position-relative h-100">
                    <img src="{{ $category->image ?? 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80' }}"
                         class="category-img w-100" alt="{{ $category->name }}">
                    <div class="category-overlay d-flex flex-column justify-content-end p-4">
                        <div class="category-content bg-white bg-opacity-75 rounded p-3">
                            <h3 class="category-title h5 mb-2">{{ $category->name }}</h3>
                            <p class="category-desc small mb-3">{{ $category->description ?? 'Khám phá các sản phẩm chất lượng cao' }}</p>
                            <a href="{{ route('client.category', $category->slug) }}" class="btn btn-primary btn-sm">
                                Xem sản phẩm <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- About Shop Section -->
    <section class="about-shop mb-5 py-4 bg-light rounded shadow">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image position-relative">
                    <img src="https://images.unsplash.com/photo-1551703599-2a1f2c7d7f13?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                         class="img-fluid rounded shadow" alt="TTG Shop">
                    <div class="about-badge position-absolute top-0 end-0 bg-primary text-white p-3 m-3 rounded-circle">
                        <div class="h5 mb-0 fw-bold">5+</div>
                        <div class="small">Năm</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 px-4 px-lg-5">
                <h2 class="section-title mb-4">TTG Shop - Chuyên gia máy tính & linh kiện</h2>
                <p class="lead mb-4">Chúng tôi cung cấp các giải pháp máy tính cao cấp, linh kiện chính hãng và dịch vụ hậu mãi chuyên nghiệp.</p>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Sản phẩm chính hãng</h5>
                                <p class="text-muted mb-0 small">100% sản phẩm chính hãng, bảo hành dài hạn</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-truck text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Giao hàng toàn quốc</h5>
                                <p class="text-muted mb-0 small">Giao hàng nhanh chóng, đóng gói cẩn thận</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-headset text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Hỗ trợ 24/7</h5>
                                <p class="text-muted mb-0 small">Luôn sẵn sàng hỗ trợ khách hàng mọi lúc</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-shield-check text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Bảo hành tận tâm</h5>
                                <p class="text-muted mb-0 small">Chế độ bảo hành chuyên nghiệp, nhanh chóng</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('client.contact') }}" class="btn btn-primary">
                    <i class="bi bi-info-circle me-2"></i>Tìm hiểu thêm
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products mb-5">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Sản phẩm nổi bật</h2>
            <a href="{{ route('client.products') }}" class="btn btn-outline-primary">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($products->take(8) as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
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
    </section>

    <!-- Special Offers Banner -->
    <section class="special-offers mb-5">
        <div class="card border-0 rounded shadow overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-8">
                        <div class="special-offer-content bg-gradient-primary text-white p-5 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold display-5 mb-3">Khuyến Mãi Đặc Biệt</h3>
                            <p class="lead mb-3">Giảm giá lên đến 30% cho tất cả các sản phẩm Gaming PC</p>
                            <div class="offer-details mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="offer-icon me-3">
                                        <i class="bi bi-clock fs-4"></i>
                                    </div>
                                    <div class="offer-text">
                                        <p class="mb-0">Chương trình kết thúc sau:</p>
                                        <div class="countdown d-flex gap-3 mt-1">
                                            <div class="countdown-item bg-white bg-opacity-25 px-3 py-2 rounded">
                                                <span class="h4 mb-0 text-white">05</span>
                                                <span class="small d-block">Ngày</span>
                                            </div>
                                            <div class="countdown-item bg-white bg-opacity-25 px-3 py-2 rounded">
                                                <span class="h4 mb-0 text-white">12</span>
                                                <span class="small d-block">Giờ</span>
                                            </div>
                                            <div class="countdown-item bg-white bg-opacity-25 px-3 py-2 rounded">
                                                <span class="h4 mb-0 text-white">45</span>
                                                <span class="small d-block">Phút</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="offer-icon me-3">
                                        <i class="bi bi-tag fs-4"></i>
                                    </div>
                                    <div class="offer-text">
                                        <p class="mb-0">Sử dụng mã: <span class="badge bg-warning text-dark p-2 ms-2 fw-bold">TTGAMING30</span></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('client.products') }}" class="btn btn-light btn-lg me-2">
                                    <i class="bi bi-cart me-2"></i>Mua ngay
                                </a>
                                <a href="{{ route('client.products') }}" class="btn btn-outline-light btn-lg">
                                    <i class="bi bi-info-circle me-2"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <img src="https://images.unsplash.com/photo-1591488320449-011701bb6704?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                             class="img-fluid h-100 object-fit-cover" alt="Gaming PC Special Offer">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products Grid -->
    <section class="popular-products mb-5">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Sản phẩm phổ biến</h2>
            <div class="section-actions">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">Tất cả</button>
                    <button type="button" class="btn btn-outline-primary">Gaming PC</button>
                    <button type="button" class="btn btn-outline-primary">Linh kiện</button>
                    <button type="button" class="btn btn-outline-primary">Phụ kiện</button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card product-card-large h-100 border-0 shadow-sm position-relative overflow-hidden">
                    <div class="row g-0 h-100">
                        <div class="col-md-6">
                            <div class="product-img-wrapper h-100">
                                <img src="https://images.unsplash.com/photo-1587202372634-32705e3bf49c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                                     class="img-fluid h-100 object-fit-cover" alt="Ultra Gaming PC">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body d-flex flex-column h-100">
                                <div class="mb-auto">
                                    <span class="badge bg-danger mb-2">Bán chạy nhất</span>
                                    <h4 class="card-title mb-2">Ultra Gaming PC RTX 4080</h4>
                                    <div class="product-rating mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span class="rating-count text-muted small ms-1">(48)</span>
                                    </div>
                                    <p class="card-text mb-3">Máy tính chơi game cao cấp với RTX 4080, Intel Core i9, 32GB RAM, 2TB SSD</p>
                                    <div class="product-price mb-3">
                                        <span class="current-price fw-bold fs-4">45.990.000đ</span>
                                        <span class="original-price text-muted text-decoration-line-through ms-2">49.990.000đ</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary flex-grow-1 me-2">
                                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row g-4 h-100">
                    @foreach($products->take(4) as $product)
                    <div class="col-md-6">
                        <div class="product-card card h-100 shadow-sm border-0 position-relative">
                            <div class="product-badges position-absolute top-0 start-0 p-2 z-1">
                                <span class="badge bg-info mb-1 d-block">Mới</span>
                            </div>
                            <div class="product-img-wrapper overflow-hidden">
                                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1591405351990-4726e331f141?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80' }}"
                                     class="card-img-top product-img" alt="{{ $product->name }}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="product-info mb-auto">
                                    <p class="product-category text-muted small mb-1">
                                        <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                                    </p>
                                    <h5 class="product-title card-title text-truncate mb-2">{{ $product->name }}</h5>
                                    <div class="product-price mb-2">
                                        <span class="current-price fw-bold">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                                <div class="product-actions mt-3">
                                    <a href="{{ route('client.product', $product->slug) }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-eye me-1"></i>Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </section>

    <!-- Testimonials -->
    <section class="testimonials mb-5">
        <div class="section-header text-center mb-5">
            <h2 class="section-title mb-3">Ý kiến khách hàng</h2>
            <p class="section-subtitle text-muted">Khách hàng nói gì về chúng tôi</p>
        </div>

        <div class="testimonial-slider position-relative">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="testimonial-rating mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="testimonial-content mb-4">
                                <p class="testimonial-text">"Tôi rất hài lòng với bộ PC Gaming mà tôi đã mua từ TTG Shop. Hiệu năng tuyệt vời, giá cả hợp lý và dịch vụ khách hàng rất chuyên nghiệp."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <div class="author-avatar me-3">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Nguyễn Văn A" class="rounded-circle" width="60" height="60">
                                </div>
                                <div class="author-info">
                                    <h6 class="author-name mb-1">Nguyễn Văn A</h6>
                                    <p class="author-title text-muted small mb-0">Khách hàng thân thiết</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="testimonial-rating mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <div class="testimonial-content mb-4">
                                <p class="testimonial-text">"Giao hàng nhanh chóng và giá cả rất cạnh tranh. Tôi đã là khách hàng hơn một năm và chưa bao giờ thất vọng. Sản phẩm luôn đúng như mô tả và chất lượng cao."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <div class="author-avatar me-3">
                                    <img src="https://randomuser.me/api/portraits/women/46.jpg" alt="Trần Thị B" class="rounded-circle" width="60" height="60">
                                </div>
                                <div class="author-info">
                                    <h6 class="author-name mb-1">Trần Thị B</h6>
                                    <p class="author-title text-muted small mb-0">Khách hàng thường xuyên</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="testimonial-rating mb-3 text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="testimonial-content mb-4">
                                <p class="testimonial-text">"Sự đa dạng của các sản phẩm thật đáng kinh ngạc. Tôi luôn tìm thấy chính xác những gì tôi đang tìm kiếm và với mức giá rất hợp lý. Đội ngũ hỗ trợ kỹ thuật rất chuyên nghiệp."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <div class="author-avatar me-3">
                                    <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Lê Văn C" class="rounded-circle" width="60" height="60">
                                </div>
                                <div class="author-info">
                                    <h6 class="author-name mb-1">Lê Văn C</h6>
                                    <p class="author-title text-muted small mb-0">Khách hàng hài lòng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section mb-5 py-5 bg-light rounded shadow">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="newsletter-icon mb-4">
                    <i class="bi bi-envelope-paper text-primary display-4"></i>
                </div>
                <h2 class="section-title mb-3">Đăng ký nhận thông tin</h2>
                <p class="section-subtitle mb-4">Đăng ký để nhận thông tin về sản phẩm mới và ưu đãi đặc biệt</p>

                <form class="newsletter-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control form-control-lg" placeholder="Nhập địa chỉ email của bạn" required>
                        <button class="btn btn-primary btn-lg" type="submit">Đăng ký</button>
                    </div>
                    <div class="form-text text-muted">
                        Chúng tôi sẽ không bao giờ chia sẻ thông tin của bạn với bên thứ ba.
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Moved Quick Links Section -->
    <section class="quick-links mb-5">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="quick-link-card bg-primary text-white rounded shadow h-100">
                    <div class="card-body text-center py-4">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-pc-display h1"></i>
                        </div>
                        <h4 class="quick-link-title">Gaming PC</h4>
                        <p class="quick-link-desc small mb-3">Máy tính chơi game hiệu năng cao</p>
                        <a href="{{ route('client.category', 'gaming-pc') }}" class="btn btn-light btn-sm stretched-link">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="quick-link-card bg-success text-white rounded shadow h-100">
                    <div class="card-body text-center py-4">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-cpu h1"></i>
                        </div>
                        <h4 class="quick-link-title">Linh kiện</h4>
                        <p class="quick-link-desc small mb-3">Linh kiện chính hãng, bảo hành dài hạn</p>
                        <a href="{{ route('client.category', 'components') }}" class="btn btn-light btn-sm stretched-link">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="quick-link-card bg-info text-white rounded shadow h-100">
                    <div class="card-body text-center py-4">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-laptop h1"></i>
                        </div>
                        <h4 class="quick-link-title">Office PC</h4>
                        <p class="quick-link-desc small mb-3">Máy tính văn phòng giá tốt</p>
                        <a href="{{ route('client.category', 'office-pc') }}" class="btn btn-light btn-sm stretched-link">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="quick-link-card bg-danger text-white rounded shadow h-100">
                    <div class="card-body text-center py-4">
                        <div class="quick-link-icon mb-3">
                            <i class="bi bi-headset h1"></i>
                        </div>
                        <h4 class="quick-link-title">Phụ kiện</h4>
                        <p class="quick-link-desc small mb-3">Phụ kiện gaming chất lượng cao</p>
                        <a href="{{ route('client.category', 'accessories') }}" class="btn btn-light btn-sm stretched-link">Xem ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    /* Hero Carousel Styles */
    .home-carousel .carousel-item {
        height: 500px;
    }

    .home-carousel .carousel-item img {
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .carousel-caption {
        top: 50%;
        transform: translateY(-50%);
        bottom: auto;
        text-align: left;
    }

    .carousel-content {
        max-width: 600px;
    }

    /* Category Card Styles */
    .category-card {
        position: relative;
        height: 250px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .category-img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .category-card:hover .category-img {
        transform: scale(1.05);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
    }

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

    /* Quick Links */
    .quick-link-card {
        transition: transform 0.3s ease;
    }

    .quick-link-card:hover {
        transform: translateY(-5px);
    }

    /* Special Offers */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    /* Section Titles */
    .section-title {
        position: relative;
        font-weight: 700;
        color: #333;
    }

    /* Testimonials */
    .testimonial-card {
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .home-carousel .carousel-item {
            height: 400px;
        }

        .carousel-caption {
            text-align: center;
        }

        .carousel-content {
            margin: 0 auto;
        }
    }
</style>
@endpush

@endsection