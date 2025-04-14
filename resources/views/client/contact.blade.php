@extends('layout.ClientLayout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="h2 mb-5 text-center">Liên hệ với chúng tôi</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Contact Information -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h4 mb-4">Thông tin liên hệ</h2>
                            <div class="d-flex flex-column gap-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-geo-alt-fill text-primary fs-4 me-3"></i>
                                    <div>
                                        <h3 class="h6 mb-1">Địa chỉ</h3>
                                        <p class="text-muted mb-0">123 Đường ABC, Quận XYZ, TP.HCM</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start">
                                    <i class="bi bi-telephone-fill text-primary fs-4 me-3"></i>
                                    <div>
                                        <h3 class="h6 mb-1">Điện thoại</h3>
                                        <p class="text-muted mb-0">(84) 123 456 789</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start">
                                    <i class="bi bi-envelope-fill text-primary fs-4 me-3"></i>
                                    <div>
                                        <h3 class="h6 mb-1">Email</h3>
                                        <p class="text-muted mb-0">contact@example.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h4 mb-4">Gửi tin nhắn</h2>
                            <form action="{{ route('client.contact.send') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input type="text" name="name" id="name" 
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" 
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Nội dung</label>
                                    <textarea name="message" id="message" rows="4" 
                                        class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        Gửi tin nhắn
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 