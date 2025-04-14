<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="{{ route('client.home') }}">
            <span class="fw-bold">TTG SHOP</span>
        </a>

        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.products') }}">Sản phẩm</a>
                </li> --}}
               
            </ul>

            <!-- Right side -->
            <ul class="navbar-nav">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-gear me-2"></i>Cài đặt tài khoản
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>