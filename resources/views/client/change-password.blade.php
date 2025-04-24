@extends('layout.ClientLayout')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h2 class="h5 mb-0"><i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu</h2>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>

                    {{-- Session Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('client.change-password') }}" method="POST">
                        @csrf
                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    required placeholder="Nhập mật khẩu hiện tại của bạn">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    required placeholder="Nhập mật khẩu mới" aria-describedby="newPasswordHelp">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div id="newPasswordHelp" class="form-text">Ít nhất 8 ký tự.</div>
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <div class="input-group">
                                 <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control"
                                    required placeholder="Nhập lại mật khẩu mới">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-key me-2"></i>Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 