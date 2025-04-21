<footer class="footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-about">
                    <a href="{{ route('client.home') }}" class="footer-logo d-flex align-items-center mb-4">
                        <i class="bi bi-pc-display text-white me-2 fs-3"></i>
                        <span class="h3 text-white mb-0">TTG Shop</span>
                    </a>
                    <p class="mb-4">TTG Shop - Chuyên cung cấp máy tính, linh kiện chính hãng, giá tốt. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng và dịch vụ tốt nhất.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Danh mục</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="{{ route('client.category', 'pc-gaming') }}">Gaming PC</a></li>
                    <li><a href="{{ route('client.category', 'pc-van-phong') }}">PC Văn Phòng</a></li>
                    <li><a href="{{ route('client.category', 'pc-core-ultra') }}">PC Core Ultra</a></li>
                    <li><a href="{{ route('client.category', 'pc-mini') }}">PC Mini</a></li>
                    <li><a href="{{ route('client.category', 'cpu') }}">CPU</a></li>
                    <li><a href="{{ route('client.category', 'mainboard') }}">Mainboard</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Thông tin</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="{{ route('client.home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('client.products') }}">Sản phẩm</a></li>
                    <li><a href="{{ route('client.products') }}?sort_by=price_low">Khuyến mãi</a></li>
                    <li><a href="{{ route('client.contact') }}">Liên hệ</a></li>
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Hướng dẫn mua hàng</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5>Liên hệ</h5>
                <ul class="footer-contact list-unstyled">
                    <li class="d-flex mb-3">
                        <div class="icon me-3">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="text">
                            123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh
                        </div>
                    </li>
                    <li class="d-flex mb-3">
                        <div class="icon me-3">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="text">
                            <a href="tel:+84123456789">+84 123 456 789</a>
                        </div>
                    </li>
                    <li class="d-flex mb-3">
                        <div class="icon me-3">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="text">
                            <a href="mailto:info@ttgshop.com">info@ttgshop.com</a>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="icon me-3">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="text">
                            Thứ 2 - Thứ 7: 8:00 - 17:30<br>
                            Chủ nhật: 8:00 - 12:00
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} TTG Shop. Tất cả các quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <div class="payment-methods">
                        <span class="me-3">Thanh toán:</span>
                        <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" alt="Visa" width="32" height="32" class="me-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" alt="MasterCard" width="32" height="32" class="me-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/217/217445.png" alt="Momo" width="32" height="32" class="me-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/1019/1019607.png" alt="Bank Transfer" width="32" height="32">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>