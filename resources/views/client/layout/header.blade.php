<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.home') }}">Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.categories') }}">Categories</a>
                    </li>
                </ul>

                <form class="d-flex me-3" action="{{ route('client.search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search products...">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <div class="d-flex">
                    <a href="{{ route('client.cart') }}" class="btn btn-outline-primary me-2">
                        <i class="bi bi-cart"></i> Cart
                        <span class="badge bg-danger">0</span>
                    </a>
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('client.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.orders') }}">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header> 