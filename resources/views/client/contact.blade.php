@extends('layout.ClientLayout')

@section('title', 'Liên hệ - TTG Shop')

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1587614382346-4ec70e388b28?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        margin-top: -16px;
        margin-bottom: 50px;
    }

    .contact-card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 50%;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .btn-contact {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        color: #0d6efd;
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background-color: #0d6efd;
        color: white;
        transform: translateY(-3px);
    }

    .map-container {
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="contact-hero">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Liên Hệ Với Chúng Tôi</h1>
        <p class="lead mb-0">Chúng tôi luôn sẵn sàng hỗ trợ và lắng nghe ý kiến của bạn</p>
    </div>
</div>

<div class="container py-5">
    <!-- Contact Info Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="contact-card card text-center h-100 p-4">
                <div class="card-body">
                    <div class="contact-icon mx-auto">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h3 class="h5 mb-3">Địa Chỉ</h3>
                    <p class="text-muted mb-0">123 Đường ABC, Quận XYZ,<br>TP. Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
            <div class="contact-card card text-center h-100 p-4">
                <div class="card-body">
                    <div class="contact-icon mx-auto">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h3 class="h5 mb-3">Điện Thoại & Email</h3>
                    <p class="text-muted mb-2">(84) 123 456 789</p>
                    <p class="text-muted mb-0">contact@ttgshop.com</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="contact-card card text-center h-100 p-4">
                <div class="card-body">
                    <div class="contact-icon mx-auto">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <h3 class="h5 mb-3">Giờ Làm Việc</h3>
                    <p class="text-muted mb-2">Thứ 2 - Thứ 7: 8:00 - 17:30</p>
                    <p class="text-muted mb-0">Chủ nhật: 8:00 - 12:00</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Contact Form -->
        <div class="col-lg-6">
            <div class="contact-card card h-100">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="h3 fw-bold mb-4">Gửi Tin Nhắn Cho Chúng Tôi</h2>
                    <p class="text-muted mb-4">Hãy cho chúng tôi biết bạn cần hỗ trợ gì. Đội ngũ của chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>

                    <form action="{{ route('client.contact.send') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">Họ tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                    class="form-control bg-light border-start-0 @error('name') is-invalid @enderror"
                                    placeholder="Nhập họ tên của bạn"
                                    value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="noi_dung" class="form-label fw-medium">Nội dung</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-chat-left-text"></i>
                                </span>
                                <textarea name="noi_dung" id="noi_dung" rows="5"
                                    class="form-control bg-light border-start-0 @error('noi_dung') is-invalid @enderror"
                                    placeholder="Nhập nội dung tin nhắn">{{ old('noi_dung') }}</textarea>
                            </div>
                            @error('noi_dung')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-contact">
                                <i class="bi bi-send-fill me-2"></i>Gửi Tin Nhắn
                            </button>
                        </div>
                    </form>

                    <div class="mt-5">
                        <h5 class="mb-3">Kết nối với chúng tôi</h5>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="col-lg-6">
            <div class="contact-card card h-100">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="h3 fw-bold mb-4">Vị Trí Của Chúng Tôi</h2>
                    <p class="text-muted mb-4">Ghé thăm showroom của chúng tôi để trải nghiệm các sản phẩm PC và linh kiện cao cấp.</p>

                    <div class="map-container mb-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674197956!2d106.69158287486876!3d10.780540089318513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3a9d8d1bb3%3A0xd2ecb62ffd4a82de!2zMTIzIMSQxrDhu51uZyBOZ3V54buFbiBUaMOhaSBIb2MsIFBoxrDhu51uZyBQaOG6oW0gTmfFqSBMw6NvLCBRdeG6rW4gMSwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1710234567890!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-truck text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Giao hàng miễn phí</h5>
                                    <p class="text-muted small mb-0">Cho đơn hàng từ 5 triệu đồng</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-shield-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Bảo hành chính hãng</h5>
                                    <p class="text-muted small mb-0">Từ 12 đến 36 tháng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="bg-light py-5 mt-5">
    <div class="container">
        <h2 class="text-center mb-5">Câu Hỏi Thường Gặp</h2>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Thời gian giao hàng mất bao lâu?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thời gian giao hàng thông thường từ 1-3 ngày làm việc đối với khu vực nội thành và 3-5 ngày đối với khu vực ngoại thành và các tỉnh thành khác.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Chính sách đổi trả sản phẩm như thế nào?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Khách hàng có thể đổi trả sản phẩm trong vòng 7 ngày kể từ ngày nhận hàng nếu sản phẩm còn nguyên vẹn, đầy đủ phụ kiện và không có dấu hiệu đã qua sử dụng.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Làm thế nào để theo dõi đơn hàng?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể theo dõi đơn hàng bằng cách đăng nhập vào tài khoản và vào mục "Đơn hàng của tôi". Tại đây bạn sẽ thấy trạng thái hiện tại của đơn hàng.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animation for contact cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.contact-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
</script>
@endpush