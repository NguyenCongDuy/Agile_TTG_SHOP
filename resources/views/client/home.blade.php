@extends('layout.ClientLayout')

@section('title', 'Home')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section py-5 mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Welcome to Our Shop</h1>
                <p class="lead">Discover amazing products at great prices</p>
                <a href="{{ route('client.products') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('dist/assets/img/1732092445z6051770101395_1dd7b13720e867422750849df651dcbf.jpg') }}" alt="Hero Image" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <section class="featured-categories mb-5">
        <h2 class="text-center mb-4">Featured Categories</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $category->image }}" class="card-img-top" alt="{{ $category->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text">{{ $category->description }}</p>
                        <a href="{{ route('client.category', $category->slug) }}" class="btn btn-outline-primary">View Products</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products mb-5">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->category->name }}</p>
                        <p class="card-text fw-bold">${{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('client.product', $product->slug) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Special Offers -->
    <section class="special-offers mb-5">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>Special Offers</h3>
                        <p class="lead">Get 20% off on all products this week!</p>
                        <a href="{{ route('client.products') }}" class="btn btn-light">Shop Now</a>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="bi bi-gift display-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 