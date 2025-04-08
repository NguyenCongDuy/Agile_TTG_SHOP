<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="{{ route('admin.home') }}" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="{{ asset('assets/img/logo.png') }}"
        alt="Logo"
        class="brand-image opacity-75 shadow"
      />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">Admin Panel</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('admin.home') }}" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Statistics -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-graph-up"></i>
            <p>
              Thống kê
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.statistics.overview') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Tổng quan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.statistics.sales') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Doanh thu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.statistics.products') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Sản phẩm</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Product Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-box-seam"></i>
            <p>
              Quản lý sản phẩm
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.products.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách sản phẩm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.products.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm sản phẩm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.products.inventory') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Quản lý kho</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Category Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-tags"></i>
            <p>
              Quản lý danh mục
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.categories.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách danh mục</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.categories.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm danh mục</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- User Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-people"></i>
            <p>
              Quản lý người dùng
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Danh sách người dùng</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.create') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Thêm người dùng</p>
              </a>
            </li>
            {{-- <li class="nav-item">
              <a href="{{ route('admin.users.roles', ['user' => $user->id])) }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Phân quyền</p>
              </a>
            </li> --}}
          </ul>
        </li>

        <!-- Client Page -->
        <li class="nav-item">
          <a href="{{ route('client.home') }}" class="nav-link">
            <i class="nav-icon bi bi-house"></i>
            <p>Về Trang Client</p>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ route('login') }}">
          </form>
          <a href="#" class="nav-link" onclick="event.preventDefault(); if(confirm('Bạn có chắc chắn muốn đăng xuất?')) { document.getElementById('logout-form').submit(); }">
            <i class="nav-icon bi bi-box-arrow-right"></i>
            <p>Đăng Xuất</p>
          </a>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>