<footer class="footer bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>About Us</h5>
                <p>Your one-stop shop for all your needs. We provide quality products at competitive prices with excellent customer service.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('client.home') }}" class="text-light">Home</a></li>
                    <li><a href="{{ route('client.products') }}" class="text-light">Products</a></li>
                    <li><a href="{{ route('client.categories') }}" class="text-light">Categories</a></li>
                    <li><a href="{{ route('client.contact') }}" class="text-light">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-geo-alt"></i> 123 Street, City, Country</li>
                    <li><i class="bi bi-telephone"></i> +123 456 7890</li>
                    <li><i class="bi bi-envelope"></i> info@shop.com</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} Shop. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-light me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-light"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer> 