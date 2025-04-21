<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('client.home') }}">
                <i class="bi bi-pc-display text-primary me-2 fs-3"></i>
                <span class="fw-bold">TTG Shop</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.home') }}">
                            <i class="bi bi-house-door me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-pc me-1"></i>Sản phẩm
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('client.products') }}">Tất cả sản phẩm</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'pc-gaming') }}">Gaming PC</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'pc-van-phong') }}">PC Văn Phòng</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'pc-core-ultra') }}">PC Core Ultra</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'pc-mini') }}">PC Mini</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Linh kiện</h6></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'cpu') }}">CPU</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'mainboard') }}">Mainboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'ram') }}">RAM</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'vga') }}">VGA</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.category', 'ssdhdd') }}">SSD/HDD</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.products') }}?sort_by=price_low">
                            <i class="bi bi-tags me-1"></i>Khuyến mãi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact') }}">
                            <i class="bi bi-headset me-1"></i>Liên hệ
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <form class="d-flex me-3" action="{{ route('client.search') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" placeholder="Tìm kiếm..." aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('client.cart') }}" class="btn btn-outline-primary position-relative me-2">
                        <i class="bi bi-cart"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('client.profile') }}">
                                    <i class="bi bi-person me-2"></i>Tài khoản của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('client.orders') }}">
                                    <i class="bi bi-box me-2"></i>Đơn hàng của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('client.change-password') }}">
                                    <i class="bi bi-key me-2"></i>Đổi mật khẩu
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus me-1"></i>Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>