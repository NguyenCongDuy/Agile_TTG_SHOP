// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart, [type="submit"][form*="cart"]');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Don't prevent default for form submissions
            if (!this.type || this.type !== 'submit') {
                e.preventDefault();
                const productId = this.dataset.productId;
                addToCart(productId);
            }
        });
    });

    // Update cart count
    function updateCartCount(count) {
        const cartBadges = document.querySelectorAll('.badge[class*="cart"], .position-absolute[class*="badge"]');
        if (cartBadges.length) {
            cartBadges.forEach(badge => {
                badge.textContent = count;
            });
        }
    }

    // Add to cart function
    function addToCart(productId) {
        // Here you would typically make an AJAX call to your backend
        // For now, we'll just update the UI
        const currentCount = parseInt(document.querySelector('.badge[class*="cart"]')?.textContent) || 0;
        updateCartCount(currentCount + 1);

        // Show success message
        showNotification('Sản phẩm đã được thêm vào giỏ hàng', 'success');
    }

    // Show notification function
    function showNotification(message, type = 'info') {
        // Check if toast container exists, if not create it
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');

        // Create toast content
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        // Add toast to container
        toastContainer.appendChild(toastEl);

        // Initialize and show toast
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });
        toast.show();

        // Remove toast after it's hidden
        toastEl.addEventListener('hidden.bs.toast', function() {
            toastEl.remove();
        });
    }

    // Quantity input controls
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        const decrementBtn = input.parentElement.querySelector('.quantity-decrement');
        const incrementBtn = input.parentElement.querySelector('.quantity-increment');

        if (decrementBtn) {
            decrementBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }

        if (incrementBtn) {
            incrementBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                let max = parseInt(input.getAttribute('max') || 99);
                if (value < max) {
                    input.value = value + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });

    // Product image gallery
    const productThumbnails = document.querySelectorAll('.product-thumbnail');
    productThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const mainImage = document.querySelector('.product-main-image');
            if (mainImage) {
                mainImage.src = this.dataset.image;
                productThumbnails.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Search functionality
    const searchForms = document.querySelectorAll('form[action*="search"]');
    searchForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="q"]');
            if (searchInput && searchInput.value.trim() === '') {
                e.preventDefault();
                showNotification('Vui lòng nhập từ khóa tìm kiếm', 'warning');
            }
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]:not([data-bs-toggle])').
    forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const autoHideAlerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    autoHideAlerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});