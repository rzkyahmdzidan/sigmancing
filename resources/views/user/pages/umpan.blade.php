@extends('user.layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Umpan Pancing</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .hero-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        .umpan-card {
            border: none;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .umpan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .umpan-card .card-header {
            padding: 20px;
            position: relative;
            border: none;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            color: white;
        }

        .umpan-card .card-body {
            padding: 20px;
            background-color: white;
        }

        .badge-recommended {
            background-color: #ffc107;
            color: #000;
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.7rem;
            padding: 6px 10px;
            font-weight: 600;
            z-index: 1;
            border-radius: 20px;
        }

        .badge-best-choice {
            background-color: #28a745;
            color: #fff;
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.7rem;
            padding: 6px 10px;
            font-weight: 600;
            z-index: 1;
            border-radius: 20px;
        }

        .category-badge {
            display: inline-block;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding: 6px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            width: 24px;
            margin-right: 8px;
            font-size: 1rem;
        }

        .filter-section {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .info-card {
            border-radius: 15px;
            padding: 20px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .info-card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .pagination {
            justify-content: center;
            margin-top: 40px;
        }

        .pagination .page-link {
            border: none;
            color: #0d6efd;
            margin: 0 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: transparent;
        }

        .modal-body .info-row {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .modal-body .info-item-modal {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .modal-body .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 15px;
        }

        .tips-section {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .tip-item {
            display: flex;
            margin-bottom: 20px;
        }

        .tip-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 15px;
            font-size: 1.5rem;
        }

        /* Color schemes for cards */
        .color-1 { background: linear-gradient(45deg, #0d6efd, #0dcaf0); }
        .color-2 { background: linear-gradient(45deg, #6610f2, #8540f5); }
        .color-3 { background: linear-gradient(45deg, #198754, #20c997); }
        .color-4 { background: linear-gradient(45deg, #fd7e14, #ffc107); }
        .color-5 { background: linear-gradient(45deg, #dc3545, #fd7e14); }
        .color-6 { background: linear-gradient(45deg, #212529, #495057); }

        /* Animasi untuk kartu */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-card {
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('user.layouts.navbar')

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container" data-aos="fade-up">
            <i class="bi bi-egg-fill hero-icon"></i>
            <h1 class="fw-bold">Rekomendasi Umpan Pancing</h1>
            <p class="lead">Temukan umpan terbaik untuk jenis ikan yang ingin Anda tangkap</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="filter-label">Jenis Ikan</div>
                    <select class="form-select" id="fish-filter">
                        <option value="">Semua Jenis Ikan</option>
                        <option value="Kakap">Kakap</option>
                        <option value="Gurami">Gurami</option>
                        <option value="Lele">Lele</option>
                        <option value="Mas">Mas</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="filter-label">Jenis Air</div>
                    <select class="form-select" id="water-filter">
                        <option value="">Semua Jenis Air</option>
                        <option value="Air Tawar">Air Tawar</option>
                        <option value="Air Laut">Air Laut</option>
                        <option value="Air Payau">Air Payau</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="filter-label">Kategori</div>
                    <select class="form-select" id="category-filter">
                        <option value="">Semua Kategori</option>
                        <option value="Natural Bait">Natural Bait</option>
                        <option value="Artificial Bait">Artificial Bait</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 mt-4" id="filter-button">
                        <i class="bi bi-funnel-fill me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card color-1 text-white">
                    <i class="bi bi-info-circle-fill info-card-icon"></i>
                    <h5 class="card-title mb-1">Pilih Dengan Tepat</h5>
                    <p class="card-text mb-0">Umpan yang tepat meningkatkan peluang mendapatkan ikan</p>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card color-3 text-white">
                    <i class="bi bi-water info-card-icon"></i>
                    <h5 class="card-title mb-1">Sesuaikan Dengan Habitat</h5>
                    <p class="card-text mb-0">Perhatikan jenis air untuk hasil yang optimal</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card color-4 text-white">
                    <i class="bi bi-clock-fill info-card-icon"></i>
                    <h5 class="card-title mb-1">Waktu Terbaik</h5>
                    <p class="card-text mb-0">Perhatikan waktu ideal untuk tiap jenis umpan</p>
                </div>
            </div>
        </div>

        <!-- Umpan Cards -->
        <div class="row">
            @foreach($umpans as $index => $umpan)
            <div class="col-md-4 umpan-item animated-card"
                 data-aos="fade-up"
                 data-aos-delay="{{ $loop->iteration * 100 }}"
                 data-fish="{{ $umpan->jenis_ikan }}"
                 data-water="{{ $umpan->jenis_air }}"
                 data-category="{{ $umpan->kategori }}">
                <div class="card umpan-card">
                    <div class="card-header color-{{ ($index % 6) + 1 }}">
                        <!-- Badge yang menunjukkan status rekomendasi -->
                        @if($umpan->badge == 'Recommended')
                            <span class="badge-recommended">REKOMENDASI</span>
                        @elseif($umpan->badge == 'Best Choice')
                            <span class="badge-best-choice">PILIHAN TERBAIK</span>
                        @endif

                        <!-- Icon umpan -->
                        <div class="text-center">
                            <i class="bi {{ $umpan->kategori == 'Natural Bait' ? 'bi-egg-fill' : 'bi-gem' }} card-icon"></i>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="category-badge">{{ $umpan->kategori }}</div>
                        <h5 class="card-title fw-bold mb-3">{{ $umpan->nama }}</h5>

                        <div class="info-item">
                            <i class="bi bi-fish-fill text-info"></i>
                            <span>{{ $umpan->jenis_ikan }}</span>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-droplet-fill text-primary"></i>
                            <span>{{ $umpan->jenis_air }}</span>
                        </div>

                        <div class="info-item">
                            <i class="bi bi-clock-fill text-warning"></i>
                            <span>{{ $umpan->waktu_terbaik }}</span>
                        </div>

                        <p class="card-text mt-3 small text-muted">
                            {{ Str::limit($umpan->deskripsi, 80) }}
                        </p>

                        <button class="btn btn-outline-primary w-100 mt-2 btn-detail"
                                data-bs-toggle="modal"
                                data-bs-target="#umpanModal{{ $umpan->id }}">
                            <i class="bi bi-info-circle me-1"></i> Detail Umpan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal untuk detail umpan -->
            <div class="modal fade" id="umpanModal{{ $umpan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header color-{{ ($index % 6) + 1 }} text-white">
                            <h5 class="modal-title fw-bold">{{ $umpan->nama }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="bi {{ $umpan->kategori == 'Natural Bait' ? 'bi-egg-fill' : 'bi-gem' }} display-1 text-{{ $umpan->kategori == 'Natural Bait' ? 'warning' : 'info' }}"></i>
                                <div class="category-badge mt-2">{{ $umpan->kategori }}</div>
                            </div>

                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-item-modal">
                                            <div class="info-icon bg-primary bg-opacity-10">
                                                <i class="bi bi-fish-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Jenis Ikan</small>
                                                <span class="fw-medium">{{ $umpan->jenis_ikan }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-item-modal">
                                            <div class="info-icon bg-info bg-opacity-10">
                                                <i class="bi bi-droplet-fill text-info"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Jenis Air</small>
                                                <span class="fw-medium">{{ $umpan->jenis_air }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="info-item-modal">
                                            <div class="info-icon bg-warning bg-opacity-10">
                                                <i class="bi bi-clock-fill text-warning"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Waktu Terbaik</small>
                                                <span class="fw-medium">{{ $umpan->waktu_terbaik }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($umpan->badge)
                            <div class="alert {{ $umpan->badge == 'Recommended' ? 'alert-warning' : 'alert-success' }} d-flex align-items-center">
                                <i class="bi {{ $umpan->badge == 'Recommended' ? 'bi-star-fill' : 'bi-trophy-fill' }} me-2"></i>
                                <div>
                                    <strong>{{ $umpan->badge == 'Recommended' ? 'Rekomendasi' : 'Pilihan Terbaik' }}</strong> untuk memancing {{ $umpan->jenis_ikan }}
                                </div>
                            </div>
                            @endif

                            <div class="mt-4">
                                <h6 class="fw-bold">Deskripsi</h6>
                                <p>{{ $umpan->deskripsi }}</p>
                            </div>

                            <div class="mt-4">
                                <h6 class="fw-bold">Tips Penggunaan</h6>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            </div>
                                            <div>Pastikan umpan dalam kondisi segar</div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            </div>
                                            <div>Gunakan ukuran yang sesuai dengan target ikan</div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            </div>
                                            <div>Perhatikan waktu terbaik untuk memancing</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">
                                <i class="bi bi-check-circle me-1"></i> Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $umpans->links('pagination::bootstrap-5') }}
        </div>

        <!-- Tips Section -->
        <div class="tips-section" data-aos="fade-up">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-lightbulb-fill me-2 text-warning"></i>Tips Memilih Umpan
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="tip-item">
                        <div class="tip-icon bg-primary bg-opacity-10">
                            <i class="bi bi-droplet-fill text-primary"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">Perhatikan Jenis Air</h6>
                            <p class="text-muted mb-0">Pilih umpan yang sesuai dengan habitat ikan target (air tawar, air laut, atau air payau).</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="tip-item">
                        <div class="tip-icon bg-warning bg-opacity-10">
                            <i class="bi bi-clock text-warning"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">Waktu Memancing</h6>
                            <p class="text-muted mb-0">Beberapa umpan lebih efektif pada waktu tertentu. Perhatikan waktu terbaik untuk setiap umpan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tip-item">
                        <div class="tip-icon bg-info bg-opacity-10">
                            <i class="bi bi-thermometer-half text-info"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">Faktor Cuaca</h6>
                            <p class="text-muted mb-0">Cuaca mempengaruhi perilaku ikan. Sesuaikan umpan dengan kondisi cuaca saat memancing.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Filtering Logic
        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filter-button');
            const fishFilter = document.getElementById('fish-filter');
            const waterFilter = document.getElementById('water-filter');
            const categoryFilter = document.getElementById('category-filter');
            const umpanItems = document.querySelectorAll('.umpan-item');

            filterButton.addEventListener('click', function() {
                const fishValue = fishFilter.value;
                const waterValue = waterFilter.value;
                const categoryValue = categoryFilter.value;

                umpanItems.forEach(item => {
                    const fishMatch = !fishValue || item.dataset.fish.includes(fishValue);
                    const waterMatch = !waterValue || item.dataset.water === waterValue;
                    const categoryMatch = !categoryValue || item.dataset.category === categoryValue;

                    if (fishMatch && waterMatch && categoryMatch) {
                        item.style.display = 'block';
                        // Reapply animation
                        item.classList.remove('animated-card');
                        void item.offsetWidth; // Trigger reflow
                        item.classList.add('animated-card');
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
