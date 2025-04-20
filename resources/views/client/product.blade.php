@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="product-detail-img mb-3">
                <img src="{{ asset($product->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}"
                     alt="{{ $product->name }}"
                     id="mainProductImage"
                     class="img-fluid rounded">
            </div>
            <div class="row product-thumbnails">
                <div class="col-3 mb-3">
                    <img src="{{ asset($product->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}"
                         alt="Thumbnail 1"
                         class="img-thumbnail product-thumbnail active"
                         onclick="changeMainImage(this.src)">
                </div>
                @if(isset($product->has_variants) && $product->has_variants)
                    @foreach($product->variants as $variant)
                        @if(isset($variant->image) && $variant->image)
                        <div class="col-3 mb-3">
                            <img src="{{ asset($variant->image) }}"
                                 alt="{{ $variant->sku ?? 'Variant' }}"
                                 class="img-thumbnail product-thumbnail"
                                 onclick="changeMainImage(this.src)">
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="h2 mb-2">{{ $product->name }}</h1>
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <span class="text-muted">(4.5/5 - 24 reviews)</span>
            </div>

            <div class="d-flex align-items-center mb-4">
                @if(isset($product->has_variants) && $product->has_variants)
                    <span id="productPrice" class="product-price me-3">${{ number_format($product->price, 2) }}</span>
                @else
                    @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                        <span class="product-price me-3">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="product-original-price">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="product-price me-3">${{ number_format($product->price, 2) }}</span>
                    @endif
                @endif

                <div class="ms-auto">
                    @if(isset($product->is_in_stock) && $product->is_in_stock)
                        <span class="badge bg-success">In Stock</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <p>{{ $product->description }}</p>
            </div>

            <!-- Product Configuration Options -->
            <form id="addToCartForm" action="{{ route('client.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" id="variantId">

                <!-- CPU Options -->
                <div class="variant-options mb-4">
                    <h6 class="fw-bold mb-2">CPU:</h6>
                    <div class="d-flex flex-wrap">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cpu" id="cpu-i5" value="intel_i5" checked>
                            <label class="form-check-label" for="cpu-i5">Intel Core i5</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cpu" id="cpu-i7" value="intel_i7">
                            <label class="form-check-label" for="cpu-i7">Intel Core i7</label>
                        </div>
                    </div>
                </div>

                <!-- RAM Options -->
                <div class="variant-options mb-4">
                    <h6 class="fw-bold mb-2">RAM:</h6>
                    <div class="d-flex flex-wrap">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ram" id="ram-16gb" value="16gb" checked>
                            <label class="form-check-label" for="ram-16gb">16GB</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ram" id="ram-32gb" value="32gb">
                            <label class="form-check-label" for="ram-32gb">32GB</label>
                        </div>
                    </div>
                </div>

                <!-- SSD Options -->
                <div class="variant-options mb-4">
                    <h6 class="fw-bold mb-2">SSD:</h6>
                    <div class="d-flex flex-wrap">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssd" id="ssd-512gb" value="512gb" checked>
                            <label class="form-check-label" for="ssd-512gb">512GB</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssd" id="ssd-1tb" value="1tb">
                            <label class="form-check-label" for="ssd-1tb">1TB</label>
                        </div>
                    </div>
                </div>

                <!-- Configuration Summary -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Cấu hình đã chọn</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-1"><strong>CPU:</strong> <span id="summary-cpu">Intel Core i5</span></p>
                                <p class="mb-1"><strong>RAM:</strong> <span id="summary-ram">16GB</span></p>
                                <p class="mb-1"><strong>SSD:</strong> <span id="summary-ssd">512GB</span></p>
                                <p class="mb-0"><strong>SKU:</strong> <span id="productSku">PC-GAMING-4070-I5-16GB-512GB</span></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h5 class="product-price mb-0" id="productPrice">{{ number_format(1999.99, 0, ',', '.') }}đ</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantity and Add to Cart -->
                <div class="d-flex align-items-center mb-4">
                    <div class="input-group me-3" style="width: 150px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control text-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                    </div>
                    <button type="button" onclick="addToCart()" class="btn btn-primary" id="addToCartBtn">
                        <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                    </button>
                    <button type="button" class="btn btn-outline-danger ms-2 wishlist-btn">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </form>

            <div class="border-top pt-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Danh mục:</h6>
                        <a href="{{ route('client.category', $product->category->slug ?? '') }}" class="text-decoration-none">
                            {{ $product->category->name ?? 'Chưa phân loại' }}
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">SKU:</h6>
                        <span id="productSku">{{ $product->sku ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <h6 class="fw-bold me-3">Share:</h6>
                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-decoration-none"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Mô tả</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Thông số kỹ thuật</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Đánh giá (24)</button>
            </li>
        </ul>
        <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-3">Mô tả sản phẩm</h4>
                        <p>{{ $product->description }}</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset($product->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                <h4 class="mb-3">Thông số kỹ thuật</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%">Brand</th>
                                <td>{{ $product->brand ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $product->model ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>SKU</th>
                                <td>{{ $product->sku ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{ $product->weight ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Dimensions</th>
                                <td>{{ $product->dimensions ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Material</th>
                                <td>{{ $product->material ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{ $product->color ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Warranty</th>
                                <td>{{ $product->warranty ?? '12 months' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h4 class="mb-3">Customer Reviews</h4>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span class="fw-bold">4.5 out of 5</span>
                        </div>
                        <p>Based on 24 reviews</p>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">5 stars</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2">18</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">4 stars</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 17%" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2">4</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">3 stars</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2">2</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">2 stars</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2">0</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">1 star</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2">0</span>
                            </div>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
                    </div>
                    <div class="col-md-8">
                        <h4 class="mb-3">Recent Reviews</h4>
                        <div class="review-item">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Reviewer" class="rounded-circle me-2" width="40">
                                    <div>
                                        <h6 class="mb-0">John Smith</h6>
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                            <h6>Excellent product!</h6>
                            <p>This product exceeded my expectations. The quality is outstanding and it works perfectly. I would definitely recommend it to anyone looking for a reliable product.</p>
                        </div>
                        <div class="review-item">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Reviewer" class="rounded-circle me-2" width="40">
                                    <div>
                                        <h6 class="mb-0">Jane Doe</h6>
                                        <small class="text-muted">1 week ago</small>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                            <h6>Great value for money</h6>
                            <p>I'm very satisfied with this purchase. The product is well-made and durable. The only minor issue is that the color is slightly different from what was shown in the pictures.</p>
                        </div>
                        <div class="review-item">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Reviewer" class="rounded-circle me-2" width="40">
                                    <div>
                                        <h6 class="mb-0">Robert Johnson</h6>
                                        <small class="text-muted">2 weeks ago</small>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                            <h6>Good product with minor flaws</h6>
                            <p>Overall, I'm happy with this product. It functions well and looks good. However, the setup was a bit complicated and the instructions could have been clearer.</p>
                        </div>
                        <nav aria-label="Review pagination">
                            <ul class="pagination justify-content-center mt-4">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h2 class="h3 mb-4">Related Products</h2>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="product-card card">
                    <div class="position-relative">
                        <img src="{{ asset($relatedProduct->image ?? 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop') }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                        @if($relatedProduct->is_featured)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">Featured</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $relatedProduct->name }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">${{ number_format($relatedProduct->price, 2) }}</span>
                            <a href="{{ route('client.product', $relatedProduct->slug) }}" class="btn btn-sm btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="reviewRating" class="form-label">Rating</label>
                            <div class="rating-stars mb-2">
                                <i class="bi bi-star fs-4 me-1" data-rating="1"></i>
                                <i class="bi bi-star fs-4 me-1" data-rating="2"></i>
                                <i class="bi bi-star fs-4 me-1" data-rating="3"></i>
                                <i class="bi bi-star fs-4 me-1" data-rating="4"></i>
                                <i class="bi bi-star fs-4" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="reviewRating" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="reviewTitle" class="form-label">Review Title</label>
                            <input type="text" class="form-control" id="reviewTitle" placeholder="Summarize your review">
                        </div>
                        <div class="mb-3">
                            <label for="reviewContent" class="form-label">Review</label>
                            <textarea class="form-control" id="reviewContent" rows="4" placeholder="Tell others about your experience with this product"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Quantity controls
function increaseQuantity() {
    const input = document.querySelector('input[name="quantity"]');
    const max = parseInt(input.getAttribute('max') || 100);
    let value = parseInt(input.value);
    if (value < max) {
        input.value = value + 1;
    }
}

function decreaseQuantity() {
    const input = document.querySelector('input[name="quantity"]');
    let value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
    }
}

// Product image gallery
function changeMainImage(src) {
    document.getElementById('mainProductImage').src = src;

    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.product-thumbnail');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('active');
        if (thumb.src === src) {
            thumb.classList.add('active');
        }
    });
}

// Product configuration selection
const variants = [
    { id: 1, sku: 'PC-GAMING-4070-I5-16GB-512GB', price: 1999.99, stock: 5, cpu: 'intel_i5', ram: '16gb', ssd: '512gb' },
    { id: 2, sku: 'PC-GAMING-4070-I5-16GB-1TB', price: 2099.99, stock: 3, cpu: 'intel_i5', ram: '16gb', ssd: '1tb' },
    { id: 3, sku: 'PC-GAMING-4070-I5-32GB-512GB', price: 2199.99, stock: 2, cpu: 'intel_i5', ram: '32gb', ssd: '512gb' },
    { id: 4, sku: 'PC-GAMING-4070-I5-32GB-1TB', price: 2299.99, stock: 4, cpu: 'intel_i5', ram: '32gb', ssd: '1tb' },
    { id: 5, sku: 'PC-GAMING-4070-I7-16GB-512GB', price: 2299.99, stock: 3, cpu: 'intel_i7', ram: '16gb', ssd: '512gb' },
    { id: 6, sku: 'PC-GAMING-4070-I7-16GB-1TB', price: 2399.99, stock: 2, cpu: 'intel_i7', ram: '16gb', ssd: '1tb' },
    { id: 7, sku: 'PC-GAMING-4070-I7-32GB-512GB', price: 2499.99, stock: 1, cpu: 'intel_i7', ram: '32gb', ssd: '512gb' },
    { id: 8, sku: 'PC-GAMING-4070-I7-32GB-1TB', price: 2599.99, stock: 2, cpu: 'intel_i7', ram: '32gb', ssd: '1tb' }
];

// Initialize with default variant
let selectedVariant = variants[0];
document.getElementById('variantId').value = selectedVariant.id;

// Add event listeners to all radio buttons
document.addEventListener('DOMContentLoaded', function() {
    // CPU options
    document.querySelectorAll('input[name="cpu"]').forEach(radio => {
        radio.addEventListener('change', updateConfiguration);
    });

    // RAM options
    document.querySelectorAll('input[name="ram"]').forEach(radio => {
        radio.addEventListener('change', updateConfiguration);
    });

    // SSD options
    document.querySelectorAll('input[name="ssd"]').forEach(radio => {
        radio.addEventListener('change', updateConfiguration);
    });
});

function updateConfiguration() {
    // Get selected values
    const selectedCPU = document.querySelector('input[name="cpu"]:checked').value;
    const selectedRAM = document.querySelector('input[name="ram"]:checked').value;
    const selectedSSD = document.querySelector('input[name="ssd"]:checked').value;

    // Update summary display
    document.getElementById('summary-cpu').textContent = selectedCPU === 'intel_i5' ? 'Intel Core i5' : 'Intel Core i7';
    document.getElementById('summary-ram').textContent = selectedRAM === '16gb' ? '16GB' : '32GB';
    document.getElementById('summary-ssd').textContent = selectedSSD === '512gb' ? '512GB' : '1TB';

    // Find matching variant
    const matchingVariant = variants.find(v =>
        v.cpu === selectedCPU &&
        v.ram === selectedRAM &&
        v.ssd === selectedSSD
    );

    if (matchingVariant) {
        selectedVariant = matchingVariant;
        updateProductInfo(matchingVariant);
    } else {
        // This shouldn't happen with our configuration, but just in case
        document.getElementById('addToCartBtn').disabled = true;
        alert('Cấu hình này không khả dụng');
    }
}

function updateProductInfo(variant) {
    // Update price
    const priceElement = document.getElementById('productPrice');
    const formattedPrice = new Intl.NumberFormat('vi-VN').format(variant.price);
    priceElement.textContent = `${formattedPrice}đ`;

    // Update SKU
    document.getElementById('productSku').textContent = variant.sku;

    // Update stock status
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (variant.stock > 0) {
        addToCartBtn.disabled = false;
        document.getElementById('quantity').setAttribute('max', variant.stock);
    } else {
        addToCartBtn.disabled = true;
    }

    // Update variant ID in form
    document.getElementById('variantId').value = variant.id;
}

function addToCart() {
    // Check if variant is selected for products with variants
    if (document.getElementById('variantId') && !document.getElementById('variantId').value) {
        alert('Vui lòng chọn đầy đủ cấu hình trước khi thêm vào giỏ');
        return;
    }

    // Submit the form
    document.getElementById('addToCartForm').submit();
}

// Review rating stars
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-stars i');
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            document.getElementById('reviewRating').value = rating;

            // Update stars UI
            ratingStars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill');
                } else {
                    s.classList.remove('bi-star-fill');
                    s.classList.add('bi-star');
                }
            });
        });
    });
});
</script>
@endsection