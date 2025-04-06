<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        .small-box {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            display: block;
            margin-bottom: 20px;
            position: relative;
        }
        .small-box > .inner {
            padding: 10px;
        }
        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            padding: 0;
            white-space: nowrap;
        }
        .small-box p {
            font-size: 1rem;
        }
        .small-box .icon {
            color: rgba(0,0,0,.15);
            z-index: 0;
        }
        .small-box .icon > i {
            font-size: 70px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: transform .3s linear;
        }
        .small-box:hover .icon > i {
            transform: scale(1.1);
        }
        .small-box .small-box-footer {
            background: rgba(0,0,0,.1);
            color: rgba(255,255,255,.8);
            display: block;
            padding: 3px 0;
            position: relative;
            text-align: center;
            text-decoration: none;
            z-index: 10;
        }
        .small-box .small-box-footer:hover {
            background: rgba(0,0,0,.15);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-bell"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-gear"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-person"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Sidebar Container -->
        @include('layout.blocks.aside')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2024 <a href="#">Admin Panel</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar menu items
            const menuItems = document.querySelectorAll('.nav-item');
            menuItems.forEach(item => {
                const link = item.querySelector('.nav-link');
                const submenu = item.querySelector('.nav-treeview');
                
                if (link && submenu) {
                    // Initially hide all submenus
                    submenu.style.display = 'none';
                    
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
                        const arrow = link.querySelector('.nav-arrow');
                        if (arrow) {
                            arrow.classList.toggle('bi-chevron-right');
                            arrow.classList.toggle('bi-chevron-down');
                        }
                    });
                }
            });

            // Set active menu item based on current URL
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.nav-link');
            
            menuLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    
                    // If it's a submenu item, show its parent menu
                    const parentItem = link.closest('.nav-treeview');
                    if (parentItem) {
                        parentItem.style.display = 'block';
                        const parentLink = parentItem.previousElementSibling;
                        if (parentLink) {
                            parentLink.classList.add('active');
                            const arrow = parentLink.querySelector('.nav-arrow');
                            if (arrow) {
                                arrow.classList.remove('bi-chevron-right');
                                arrow.classList.add('bi-chevron-down');
                            }
                        }
                    }
                }
            });
        });

        // Add fade effect to alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 3000);
        });
    </script>
    @stack('scripts')
</body>
</html> 