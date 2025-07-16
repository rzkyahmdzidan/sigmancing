<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* CSS Fix untuk sidebar */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        /* CSS untuk navbar yang bisa ditutup */
        .navbar {
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar.hidden {
            margin-top: -60px;
        }

        .content-wrapper {
            transition: all 0.3s ease;
            padding-top: 1rem;
        }

        .navbar.hidden+.content-wrapper {
            padding-top: 0;
        }

        .navbar-toggle {
            position: absolute;
            bottom: -20px;
            right: 20px;
            width: 40px;
            height: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1030;
        }

        .show-navbar {
            position: fixed;
            top: 0;
            right: 20px;
            width: 40px;
            height: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1030;
        }

        .navbar.hidden~.show-navbar {
            display: flex;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            @include('admin.layouts.navbar')

            <!-- Tombol untuk menampilkan navbar saat disembunyikan -->
            <div class="show-navbar" id="show-navbar">
                <i class="fas fa-chevron-down"></i>
            </div>

            <!-- Content -->
            <div class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const closeSidebar = document.getElementById('close-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const navbar = document.querySelector('.navbar');
            const navbarToggle = document.getElementById('navbar-toggle');
            const showNavbar = document.getElementById('show-navbar');

            // Sidebar toggle functionality
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                });
            }

            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                });
            }

            // Navbar toggle functionality - Diperbaiki
            if (navbarToggle) {
                navbarToggle.addEventListener('click', function() {
                    console.log('Navbar toggle clicked');
                    navbar.classList.add('hidden');
                });
            }

            if (showNavbar) {
                showNavbar.addEventListener('click', function() {
                    console.log('Show navbar clicked');
                    navbar.classList.remove('hidden');
                });
            }

            // Cek ukuran layar dan atur sidebar
            function checkScreenSize() {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                } else {
                    sidebar.classList.remove('active'); // Pada desktop, gunakan default dari CSS
                }
            }

            // Periksa ukuran layar saat dimuat
            checkScreenSize();

            // Pantau perubahan ukuran layar
            window.addEventListener('resize', checkScreenSize);

            // Auto-close alerts setelah 5 detik
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>

</html>
