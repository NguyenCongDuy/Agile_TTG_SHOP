@extends('layout.ClientLayout')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="text-center p-4 bg-primary bg-gradient text-white rounded-top">
                        <div class="mb-3">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                 class="rounded-circle img-thumbnail" 
                                 width="100" 
                                 alt="Profile Picture">
                        </div>
                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                        <p class="small mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="list-group list-group-flush rounded-bottom">
                        <a href="{{ route('client.profile') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('client.profile') ? 'active' : '' }}">
                            <i class="bi bi-person-fill me-2"></i>Thông tin cá nhân
                        </a>
                        <a href="{{ route('client.orders') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('client.orders') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i>Đơn hàng của tôi
                        </a>
                        <a href="{{ route('client.change-password') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('client.change-password') ? 'active' : '' }}">
                            <i class="bi bi-key-fill me-2"></i>Đổi mật khẩu
                        </a>
                        <a href="#" 
                           class="list-group-item list-group-item-action text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
            <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Profile Information -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Thông tin cá nhân
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>Cập nhật thông tin thành công!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('patch')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            {{-- <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Ngày sinh</label>
                                <input type="date" 
                                       class="form-control @error('birthday') is-invalid @enderror" 
                                       id="birthday" 
                                       name="birthday" 
                                       value="{{ old('birthday', $user->birthday) }}">
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>

                        {{-- <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 text-danger">
                        <i class="bi bi-trash3 me-2"></i>Xóa tài khoản
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Khi xóa tài khoản, tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, 
                        vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.
                    </p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item-action {
        padding: 1rem 1.5rem;
        border: none;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
    
    .list-group-item-action:last-child {
        border-bottom: none;
    }

    .list-group-item-action.active {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--bs-primary);
        font-weight: 500;
    }

    .list-group-item-action:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .list-group-item-action.active i {
        color: var(--bs-primary);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }

    .btn-primary {
        padding: 0.5rem 1.5rem;
    }

    .invalid-feedback {
        font-size: 0.875em;
    }
</style>
@endpush 
