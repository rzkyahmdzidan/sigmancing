{{-- Simpan file ini sebagai layouts/navbar.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container">
        <!-- Logo dan Nama Website -->
        <a class="navbar-brand" href="/">Informasi Spot Memancing</a>

        <!-- Tombol Toggle untuk Tampilan Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/umpan">
                        <i class="bi bi-basket me-1"></i> Rekomendasi Umpan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/toko">
                        <i class="bi bi-shop me-1"></i> Toko Pancing
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
