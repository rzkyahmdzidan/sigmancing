@extends('user.layouts.app')

@section('content')
    @include('user.layouts.navbar')

    <!-- Hero Section -->
    <div class="hero-section position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Informasi Spot Memancing</h1>
                    <p class="lead text-muted mb-5">
                        Dapatkan Informasi Mengenai Spot Potensial Memancing di Pesisir dan Sekitar kota Lhokseumawe untuk
                        mendapatkan pengalaman memancing terbaik
                    </p>
                    <a href="{{ route('spot.index') }}" class="btn btn-danger px-4 py-2 rounded-pill position-relative"
                        style="z-index: 10;">
                        <i class="bi bi-geo-alt-fill me-2"></i>Dapatkan Spot
                    </a>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('images/logobesar.png') }}" alt="Fishing Icon" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="wave-bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#f8f9fa" fill-opacity="1"
                    d="M0,128L48,144C96,160,192,192,288,197.3C384,203,480,181,576,160C672,139,768,117,864,128C960,139,1056,181,1152,186.7C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Featured Spots Section -->
    <div class="section-spots py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Spot Memancing Populer</h2>
                <p class="text-muted">Temukan spot memancing terbaik di sekitar Lhokseumawe</p>
            </div>

            <div class="row">
                @if (isset($spots) && count($spots) > 0)
                    @foreach ($spots as $spot)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card spot-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="spot-icon text-center p-4 bg-primary bg-gradient text-white">
                                    <i class="bi bi-water fs-1"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $spot->nama_spot }}</h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                        <span class="text-muted">{{ $spot->lokasi }}</span>
                                    </div>
                                    <p class="card-text">{{ Str::limit($spot->deskripsi, 100) }}</p>
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <div class="badge bg-light text-primary">
                                            <i class="bi bi-fish me-1"></i>{{ $spot->jenis_ikan }}
                                        </div>
                                        <a href="{{ route('spot.index') }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Belum ada spot memancing yang tersedia
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('spot.index') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-compass me-2"></i>Lihat Semua Spot
                </a>
            </div>
        </div>
    </div>

    <!-- Toko Pancing Section -->
    <div class="section-toko py-5">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Toko Pancing Terdekat</h2>
                <p class="text-muted">Temukan toko pancing dengan peralatan lengkap di sekitar Anda</p>
            </div>

            <div class="row">
                @if (isset($tokos) && count($tokos) > 0)
                    @foreach ($tokos as $toko)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card toko-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="toko-icon text-center p-4 bg-danger bg-gradient text-white">
                                    <i class="bi bi-shop fs-1"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $toko->nama }}</h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                        <span class="text-muted">{{ $toko->alamat }}</span>
                                    </div>

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-clock-fill text-success me-2"></i>
                                        <span class="text-muted">{{ substr($toko->jam_buka, 0, 5) }} -
                                            {{ substr($toko->jam_tutup, 0, 5) }}</span>
                                    </div>

                                    <p class="card-text">{{ Str::limit($toko->deskripsi, 80) }}</p>

                                    <div class="mt-3 text-end">
                                        <a href="{{ route('toko.index') }}"
                                            class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Belum ada toko pancing yang tersedia
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('toko.index') }}" class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-shop me-2"></i>Lihat Semua Toko
                </a>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Umpan Section -->
    <div class="section-umpan py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Rekomendasi Umpan</h2>
                <p class="text-muted">Pilih umpan terbaik untuk hasil memancing maksimal</p>
            </div>

            <div class="row">
                @if (isset($umpans) && count($umpans) > 0)
                    @foreach ($umpans as $index => $umpan)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="card umpan-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="umpan-header text-center p-4 text-white"
                                    style="background: {{ $index % 2 == 0 ? 'linear-gradient(45deg, #0d6efd, #0dcaf0)' : 'linear-gradient(45deg, #fd7e14, #ffc107)' }}">
                                    <i
                                        class="bi {{ $umpan->kategori == 'Natural Bait' ? 'bi-egg-fill' : 'bi-gem' }} fs-1"></i>
                                    @if ($umpan->badge)
                                        <div
                                            class="badge bg-white text-{{ $index % 2 == 0 ? 'primary' : 'warning' }} position-absolute top-0 end-0 m-3 rounded-pill px-3">
                                            {{ $umpan->badge == 'Recommended' ? 'Rekomendasi' : 'Pilihan Terbaik' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <div class="badge bg-light text-primary mb-2">{{ $umpan->kategori }}</div>
                                    <h5 class="card-title fw-bold">{{ $umpan->nama }}</h5>

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-fish text-info me-2"></i>
                                        <span class="text-muted">{{ $umpan->jenis_ikan }}</span>
                                    </div>

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-droplet-fill text-primary me-2"></i>
                                        <span class="text-muted">{{ $umpan->jenis_air }}</span>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <a href="{{ route('umpan.index') }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Belum ada rekomendasi umpan yang tersedia
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('umpan.index') }}" class="btn btn-warning rounded-pill px-4">
                    <i class="bi bi-egg-fill me-2"></i>Lihat Semua Umpan
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="section-features py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="feature-card text-center p-4 h-100 rounded-4 border">
                        <div class="icon-wrapper mb-4 mx-auto bg-primary bg-opacity-10 text-primary rounded-circle p-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-geo-alt-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Lokasi Akurat</h4>
                        <p class="text-muted">Informasi lokasi spot memancing yang akurat dengan dukungan peta interaktif
                        </p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center p-4 h-100 rounded-4 border">
                        <div class="icon-wrapper mb-4 mx-auto bg-success bg-opacity-10 text-success rounded-circle p-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-shop fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Toko Terlengkap</h4>
                        <p class="text-muted">Informasi lengkap tentang toko pancing disekitar kota Lhokseumawe</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center p-4 h-100 rounded-4 border">
                        <div class="icon-wrapper mb-4 mx-auto bg-warning bg-opacity-10 text-warning rounded-circle p-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-info-circle-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Rekomendasi Umpan</h4>
                        <p class="text-muted">Dapatkan rekomendasi umpan terbaik sesuai jenis ikan yang ingin dipancing</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="section-cta py-5 bg-primary text-white" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold">Siap untuk memulai petualangan memancing?</h2>
                    <p class="lead mb-0">Temukan spot memancing terbaik di sekitar Lhokseumawe sekarang!</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('spot.index') }}" class="btn btn-light btn-lg rounded-pill px-4">
                        <i class="bi bi-compass me-2"></i>Jelajahi Spot
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('user.layouts.footer')


    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true
            });
        });
    </script>
@endsection
