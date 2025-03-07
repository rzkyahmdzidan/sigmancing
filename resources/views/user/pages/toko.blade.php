@extends('user.layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Toko Pancing</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        #map {
            height: 500px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .control-card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            background-color: white;
        }

        .btn-location {
            background: linear-gradient(90deg, #0d6efd, #0096c7);
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        .btn-location:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.4);
        }

        .map-type-control .btn {
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .map-type-control .btn.active {
            background-color: #0d6efd;
            color: white;
        }

        /* Styling untuk popup */
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .leaflet-popup-content {
            margin: 13px 19px;
        }

        /* Animasi untuk marker */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .pulse-animation {
            animation: pulse 1.5s infinite;
        }

        /* Custom responsive styles */
        @media (max-width: 768px) {
            #map {
                height: 400px;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('user.layouts.navbar')

    <!-- Hero Section -->
    <div class="hero-section"
        style="background: #ffffff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-bottom: 1px solid #eee;">
        <div class="container text-center" data-aos="fade-down">
            <i class="bi bi-compass fishing-icon text-primary"></i>
            <h1 class="hero-title text-dark">Peta Toko Pancing</h1>
            <p class="hero-subtitle text-dark">Temukan toko pancing terbaik di sekitar Anda dengan informasi lengkap dan
                petunjuk arah.</p>
        </div>
    </div>

    <div class="container">
        <!-- Control Panel Card -->
        <div class="control-card p-3 mb-4" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <button class="btn btn-location" id="getLocationBtn">
                    <i class="bi bi-geo-alt-fill me-2"></i> Ambil Lokasi Saya
                </button>
                <div class="map-type-control mt-2 mt-md-0">
                    <button class="btn btn-sm btn-outline-primary active me-2" id="standardMapBtn">
                        <i class="bi bi-map me-1"></i> Peta Standar
                    </button>
                    <button class="btn btn-sm btn-outline-primary" id="satelliteMapBtn">
                        <i class="bi bi-globe me-1"></i> Satelit
                    </button>
                </div>
            </div>
        </div>

        <!-- Map Card -->
        <div class="card shadow-sm rounded-4" data-aos="zoom-in">
            <div class="card-body p-0">
                <div id="map"></div>
                <div class="map-info bg-light p-3 rounded-bottom-4">
                    <div class="row text-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-shop text-primary me-2 fs-4"></i>
                                <div class="text-start">
                                    <small class="text-muted d-block">Jumlah Toko</small>
                                    <span class="fw-bold">{{ count($tokos) }} Toko</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-geo-alt text-danger me-2 fs-4"></i>
                                <div class="text-start">
                                    <small class="text-muted d-block">Area Cakupan</small>
                                    <span class="fw-bold">Sekitar Anda</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-info-circle text-success me-2 fs-4"></i>
                                <div class="text-start">
                                    <small class="text-muted d-block">Informasi Toko</small>
                                    <span class="fw-bold">Lengkap & Akurat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="card mt-4 mb-4 border-0 bg-light shadow-sm rounded-4" data-aos="fade-up">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary">
                    <i class="bi bi-lightbulb-fill me-2"></i> Tips Mencari Toko Pancing
                </h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary fs-3">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Gunakan Fitur Lokasi</h6>
                                <p class="small text-muted">Aktifkan lokasi Anda untuk mendapatkan rekomendasi toko
                                    pancing terdekat.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary fs-3">
                                <i class="bi bi-signpost-split-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Dapatkan Rute</h6>
                                <p class="small text-muted">Klik pada toko untuk mendapatkan petunjuk arah menuju
                                    lokasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            once: true
        });

        // Initialize map
        var map;
        var userMarker; // Variabel untuk menyimpan marker lokasi pengguna
        var tokoMarkers = []; // Array untuk menyimpan semua marker toko
        var userLat = null; // Variabel untuk menyimpan latitude pengguna
        var userLng = null; // Variabel untuk menyimpan longitude pengguna
        var routingControl;


        // Definisikan base layers
        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        });

        // Layer satelit dari Esri
        var satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 17,
                attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

        // Inisialisasi map dengan layer default
        map = L.map('map', {
            center: [5.1801, 97.1507], // Koordinat Lhokseumawe
            zoom: 13,
            zoomControl: true,
            layers: [osmLayer] // Default layer
        });

        // Definisikan base layers untuk control
        var baseLayers = {
            "Peta Standar": osmLayer,
            "Satelit": satelliteLayer
        };

        // Tambahkan control layer ke peta
        L.control.layers(baseLayers, null, {
            position: 'topright'
        }).addTo(map);

        // Event listener untuk tombol peta standar dan satelit
        document.getElementById('standardMapBtn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('satelliteMapBtn').classList.remove('active');
            map.removeLayer(satelliteLayer);
            map.addLayer(osmLayer);
        });

        document.getElementById('satelliteMapBtn').addEventListener('click', function() {
            this.classList.add('active');
            document.getElementById('standardMapBtn').classList.remove('active');
            map.removeLayer(osmLayer);
            map.addLayer(satelliteLayer);
        });

        // Pastikan peta dirender dengan benar
        setTimeout(function() {
            map.invalidateSize();
        }, 100);

        // Debug info
        console.log("Data toko dari server:");
        @foreach ($tokos as $toko)
            console.log({
                id: {{ $toko->id }},
                nama: "{{ $toko->nama }}",
                alamat: "{{ $toko->alamat }}",
                jam_buka: "{{ $toko->jam_buka }}",
                jam_tutup: "{{ $toko->jam_tutup }}"
            });
        @endforeach

        // Fungsi untuk menghitung jarak antara dua titik koordinat (dalam meter)
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // radius bumi dalam meter
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const d = R * c;

            return d; // jarak dalam meter
        }

        // Fungsi untuk memformat jarak ke format yang lebih mudah dibaca
        function formatDistance(distance) {
            if (distance < 1000) {
                return Math.round(distance) + " meter";
            } else {
                return (distance / 1000).toFixed(2) + " km";
            }
        }

        // Modifikasi fungsi createPopupContent untuk tampilan yang lebih menarik
        function createPopupContent(toko, includeDistance = false) {
            let content = '<div class="popup-content" style="min-width: 260px;">' +
                '<h5 style="font-size: 17px; font-weight: 700; color: #0d6efd; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">' +
                toko.name + '</h5>';

            // Informasi lokasi dengan ikon
            content += '<div style="margin-bottom: 8px; display: flex;">' +
                '<i class="bi bi-geo-alt-fill" style="color: #dc3545; min-width: 24px; font-size: 16px;"></i> ' +
                '<span style="color: #333; font-size: 14px;">' + toko.location + '</span></div>';

            // Format jam operasional yang lebih ringkas (menghilangkan detik)
            let openTimeFormatted = toko.open_time.split(':').slice(0, 2).join('.');
            let closeTimeFormatted = toko.close_time.split(':').slice(0, 2).join('.');

            // Informasi jam buka (tanpa status)
            content += '<div style="margin-bottom: 8px; display: flex;">' +
                '<i class="bi bi-clock-fill" style="color: #198754; min-width: 24px; font-size: 16px;"></i> ' +
                '<span style="color: #333; font-size: 14px;">' + openTimeFormatted + ' - ' + closeTimeFormatted +
                '</span></div>';

            // Menambahkan status toko (buka/tutup) di bawah jam operasional
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();
            const currentTime = currentHour * 60 + currentMinute; // konversi ke menit

            // Parse jam buka dan tutup
            const [openHour, openMinute] = toko.open_time.split(':').map(Number);
            const [closeHour, closeMinute] = toko.close_time.split(':').map(Number);

            const openTime = openHour * 60 + openMinute; // konversi ke menit
            const closeTime = closeHour * 60 + closeMinute; // konversi ke menit

            // Cek apakah toko sedang buka
            const isOpen = currentTime >= openTime && currentTime <= closeTime;

            // Tampilkan status dengan warna yang sesuai
            content += '<div style="display: flex; margin-bottom: 12px; align-items: center;">' +
                '<i class="bi bi-shop" style="color: ' + (isOpen ? '#198754' : '#dc3545') +
                '; min-width: 24px; font-size: 16px;"></i> ' +
                '<span class="status-badge" style="display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background-color: ' +
                (isOpen ? '#d1e7dd' : '#f8d7da') + '; color: ' + (isOpen ? '#0f5132' : '#842029') + ';">' +
                (isOpen ? 'BUKA' : 'TUTUP') + '</span></div>';

            // Informasi telepon jika ada
            if (toko.phone) {
                content +=
                    '<div style="margin-bottom: 8px; display: flex;">' +
                    '<i class="bi bi-telephone-fill" style="color: #0d6efd; min-width: 24px; font-size: 16px;"></i> ' +
                    '<span style="color: #333; font-size: 14px;">' + toko.phone + '</span></div>';
            }

            // Tambahkan tombol untuk mendapatkan rute dengan styling lebih menarik
            content += '<div style="margin: 15px 0;">' +
                '<button onclick="showRouteTo({lat: ' + toko.lat + ', lng: ' + toko.lng + ', name: \'' + toko.name +
                '\', location: \'' + toko.location + '\'})" ' +
                'class="btn btn-primary w-100 rounded-pill shadow-sm" style="font-weight: 600; padding: 8px 15px;">' +
                '<i class="bi bi-signpost-2-fill me-2"></i> Dapatkan Rute</button></div>';

            // Tambahkan deskripsi jika ada
            if (toko.description) {
                content +=
                    '<div style="margin: 12px 0; padding: 10px; background-color: #f8f9fa; border-radius: 8px; border-left: 3px solid #0d6efd;">' +
                    '<span style="color: #495057; font-size: 13px;">' + toko.description + '</span></div>';
            }

            // Buat carousel gambar yang lebih menarik
            if (toko.images && Array.isArray(toko.images) && toko.images.length > 0) {
                // Buat container dengan style yang lebih baik
                content +=
                    '<div class="simple-carousel" style="margin: 12px 0; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">';

                // Tampilkan gambar pertama saja (yang aktif)
                content += `<img src="${toko.images[0]}" class="carousel-image active" data-index="0"
                           style="width: 100%; height: 160px; object-fit: cover;">`;

                // Tambahkan navigasi dots yang lebih menarik
                if (toko.images.length > 1) {
                    content +=
                        '<div class="carousel-dots" style="text-align: center; margin: 8px 0; position: relative; bottom: 5px;">';
                    for (let i = 0; i < toko.images.length; i++) {
                        content +=
                            `<span class="carousel-dot" data-index="${i}"
                                  style="display: inline-block; width: 8px; height: 8px; border-radius: 50%;
                                  background-color: ${i === 0 ? '#0d6efd' : '#dee2e6'}; margin: 0 3px; transition: all 0.3s ease;"></span>`;
                    }
                    content += '</div>';

                    // Tambahkan data gambar untuk script (tersembunyi)
                    content += `<div class="carousel-data" style="display:none;"
                               data-images='${JSON.stringify(toko.images)}' data-total="${toko.images.length}"></div>`;
                }

                content += '</div>';
            } else if (toko.image) {
                // Fallback untuk single image dengan styling yang lebih baik
                content += '<img src="' + toko.image + '" class="img-fluid rounded my-2 shadow-sm" alt="' + toko.name +
                    '" style="max-height: 160px; width: 100%; object-fit: cover;">';
            }

            // Jarak dari lokasi pengguna dengan styling yang lebih menarik
            if (includeDistance && userLat !== null && userLng !== null) {
                const distance = getDistance(userLat, userLng, toko.lat, toko.lng);
                const distanceText = formatDistance(distance);
                content += '<div style="margin-top: 12px; border-top: 1px solid #e9ecef; padding-top: 12px;">' +
                    '<div style="display: flex; align-items: center;">' +
                    '<i class="bi bi-pin-map-fill me-2" style="color: #6c757d; font-size: 16px;"></i>' +
                    '<span style="font-size: 13px; color: #495057;">Jarak dari lokasi Anda:</span>' +
                    '</div>' +
                    '<div style="font-size: 18px; color: #0d6efd; font-weight: 700; margin-top: 5px; text-align: center;">' +
                    distanceText + '</div></div>';
            }

            content += '</div>';
            return content;
        }

        // Fungsi untuk menampilkan rute ke toko pancing
        function showRouteTo(toko) {
            // Pastikan lokasi pengguna tersedia
            if (userLat === null || userLng === null) {
                alert("Silakan ambil lokasi Anda terlebih dahulu dengan klik tombol 'Ambil Lokasi Saya'");
                return;
            }

            // Hapus routing control yang lama jika ada
            if (routingControl) {
                map.removeControl(routingControl);
            }

            // Buat routing control baru
            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLng),
                    L.latLng(toko.lat, toko.lng)
                ],
                routeWhileDragging: true,
                lineOptions: {
                    styles: [{
                        color: '#0d6efd',
                        weight: 5,
                        opacity: 0.7
                    }]
                },
                createMarker: function() {
                    return null;
                }, // Nonaktifkan marker tambahan
                show: false // Nonaktifkan panel instruksi
            }).addTo(map);

            // Tambahkan info tentang toko di panel info rute
            routingControl.on('routesfound', function(e) {
                var routes = e.routes;
                var summary = routes[0].summary;

                // Format waktu
                var hours = Math.floor(summary.totalTime / 3600);
                var minutes = Math.floor((summary.totalTime % 3600) / 60);
                var timeString = '';

                if (hours > 0) {
                    timeString += hours + ' jam ';
                }
                timeString += minutes + ' menit';

                // Format jarak
                var distanceString = (summary.totalDistance / 1000).toFixed(1) + ' km';

                // Update informasi rute dengan desain yang lebih menarik
                var routeInfoHtml = `
                <div class="route-info-container p-3 bg-white rounded shadow-sm">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-shop-window text-primary me-2 fs-4"></i>
                        <h5 class="mb-0 fw-bold">${toko.name}</h5>
                    </div>
                    <div class="route-details bg-light p-2 rounded-3 my-2">
                        <div class="d-flex justify-content-between">
                            <div class="text-center px-2">
                                <i class="bi bi-rulers text-secondary"></i>
                                <div class="fs-5 fw-bold text-primary">${distanceString}</div>
                                <small class="text-muted">Jarak</small>
                            </div>
                            <div class="border-start"></div>
                            <div class="text-center px-2">
                                <i class="bi bi-stopwatch text-secondary"></i>
                                <div class="fs-5 fw-bold text-primary">${timeString}</div>
                                <small class="text-muted">Waktu</small>
                            </div>
                        </div>
                    </div>
                    <p class="small text-muted mb-2">Lokasi: ${toko.location}</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary rounded-pill w-100" onclick="window.open('https://www.google.com/maps/dir/?api=1&destination=${toko.lat},${toko.lng}', '_blank')">
                            <i class="bi bi-google me-1"></i> Google Maps
                        </button>
                        <button class="btn btn-outline-danger rounded-pill" onclick="clearRoute()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                `;

                // Tambahkan ke dalam container routing dengan delay
                setTimeout(function() {
                    document.querySelector('.leaflet-routing-container').insertAdjacentHTML('beforeend',
                        routeInfoHtml);
                }, 500);
            });
        }

        // Fungsi untuk menghapus rute
        function clearRoute() {
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
        }

        // Function untuk memperbarui semua popup dengan informasi jarak
        function updateAllPopupsWithDistance() {
            if (userLat === null || userLng === null) return;

            // Data toko dari database
            const tokos = [
                @foreach ($tokos as $toko)
                    @if ($toko->latitude && $toko->longitude)
                        {
                            name: "{{ $toko->nama }}",
                            location: "{{ $toko->alamat }}",
                            description: "{{ Str::limit($toko->deskripsi, 100) }}",
                            lat: {{ $toko->latitude }},
                            lng: {{ $toko->longitude }},
                            open_time: "{{ $toko->jam_buka }}",
                            close_time: "{{ $toko->jam_tutup }}",
                            phone: "{{ $toko->no_telp }}",
                            @if ($toko->gambar)
                                <?php
                                $gambarArray = json_decode($toko->gambar, true);
                                $gambarArray = is_array($gambarArray) ? $gambarArray : [];
                                ?>
                                @if (count($gambarArray) > 0)
                                    image: "{{ asset('images/toko/' . $gambarArray[0]) }}",
                                    images: [
                                        @foreach ($gambarArray as $img)
                                            "{{ asset('images/toko/' . $img) }}",
                                        @endforeach
                                    ],
                                @else
                                    image: null,
                                    images: [],
                                @endif
                            @else
                                image: null,
                                images: [],
                            @endif
                            index: {{ $loop->index }}
                        },
                    @endif
                @endforeach
            ];

            // Update setiap marker dengan popup baru yang berisi jarak
            tokos.forEach((toko, index) => {
                const popupContent = createPopupContent(toko, true);
                tokoMarkers[toko.index].setPopupContent(popupContent);
            });
        }

        // Ambil data toko dari database dan tampilkan sebagai marker
        @if (isset($tokos) && count($tokos) > 0)
            @foreach ($tokos as $toko)
                @if ($toko->latitude && $toko->longitude)
                    // Bagian pembuatan tokosData yang benar
                    var tokoData = {
                        name: "{{ $toko->nama }}",
                        location: "{{ $toko->alamat }}",
                        description: "{{ Str::limit($toko->deskripsi, 100) }}",
                        lat: {{ $toko->latitude }},
                        lng: {{ $toko->longitude }},
                        open_time: "{{ $toko->jam_buka }}",
                        close_time: "{{ $toko->jam_tutup }}",
                        phone: "{{ $toko->no_telp }}",
                        @if ($toko->gambar)
                            <?php
                            $gambarArray = json_decode($toko->gambar, true);
                            $gambarArray = is_array($gambarArray) ? $gambarArray : [];
                            ?>
                            @if (count($gambarArray) > 0)
                                image: "{{ asset('images/toko/' . $gambarArray[0]) }}",
                                images: [
                                    @foreach ($gambarArray as $img)
                                        "{{ asset('images/toko/' . $img) }}",
                                    @endforeach
                                ],
                            @else
                                image: null,
                                images: [],
                            @endif
                        @else
                            image: null,
                            images: [],
                        @endif
                    };
                    // Buat popup content tanpa jarak awalnya
                    var initialPopupContent = createPopupContent(tokoData, false);

                    // Gunakan custom icon untuk toko
                    var marker = L.marker([tokoData.lat, tokoData.lng])
                        .bindPopup(initialPopupContent, {
                            minWidth: 250,
                            maxWidth: 300
                        });

                    marker.addTo(map);
                    tokoMarkers.push(marker);

                    // Event listener untuk popup
                    marker.on('popupopen', function() {
                        setTimeout(function() {
                            // Setup carousel ketika popup dibuka
                            setupCarousel();

                            const routeBtn = document.querySelector('.leaflet-popup-content button');
                            if (routeBtn) {
                                routeBtn.addEventListener('click', function() {
                                    marker.closePopup();
                                });
                            }
                        }, 100);
                    });

                    // Tambahkan event listener untuk mengupdate popup dengan jarak saat dibuka
                    marker.on('click', function() {
                        if (userLat !== null && userLng !== null) {
                            // Update popup content dengan jarak
                            var popupContent = createPopupContent(tokoData, true);
                            marker.setPopupContent(popupContent);
                        }
                    });
                @endif
            @endforeach

            // Jika ada toko, atur tampilan peta untuk menampilkan semua toko
            @if (count($tokos) > 0)
                // Membuat grup untuk semua marker toko
                var group = new L.featureGroup(tokoMarkers);

                // Atur tampilan peta untuk menampilkan semua toko
                if (group && group.getBounds().isValid()) {
                    map.fitBounds(group.getBounds().pad(0.2));
                }
            @endif
        @else
            console.log("Tidak ada data toko yang tersedia.");
        @endif

        // Fungsi setup carousel - dalam scope global
        function setupCarousel() {
            // Fungsi untuk menghandle klik dot
            const dots = document.querySelectorAll('.carousel-dot');
            if (!dots.length) return;

            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const dotIndex = parseInt(this.dataset.index);
                    const carousel = this.closest('.simple-carousel');
                    if (!carousel) return;

                    updateCarouselImage(carousel, dotIndex);
                });
            });

            // Setup touch events untuk image swipe
            const carouselImages = document.querySelectorAll('.carousel-image');
            carouselImages.forEach(img => {
                let startX, endX;

                img.addEventListener('touchstart', function(e) {
                    startX = e.changedTouches[0].clientX;
                }, {
                    passive: true
                });

                img.addEventListener('touchend', function(e) {
                    endX = e.changedTouches[0].clientX;
                    handleSwipe(this, startX, endX);
                }, {
                    passive: true
                });
            });
        }

        // Fungsi untuk handle swipe
        function handleSwipe(img, startX, endX) {
            if (!startX || !endX) return;

            const carousel = img.closest('.simple-carousel');
            if (!carousel) return;

            const currentIndex = parseInt(img.dataset.index);
            const dataElement = carousel.querySelector('.carousel-data');
            if (!dataElement) return;

            const totalImages = parseInt(dataElement.dataset.total || 0);
            if (totalImages <= 1) return;

            const diff = startX - endX;
            const threshold = 50; // minimal jarak swipe
            let newIndex = currentIndex;

            if (Math.abs(diff) < threshold) return;

            if (diff > 0) {
                // Swipe kiri (next)
                newIndex = (currentIndex + 1) % totalImages;
            } else {
                // Swipe kanan (prev)
                newIndex = (currentIndex - 1 + totalImages) % totalImages;
            }

            updateCarouselImage(carousel, newIndex);
        }

        // Fungsi untuk update gambar carousel
        function updateCarouselImage(carousel, newIndex) {
            const dataElement = carousel.querySelector('.carousel-data');
            if (!dataElement) return;

            try {
                const images = JSON.parse(dataElement.dataset.images);
                if (!images || !images.length) return;

                const carouselImage = carousel.querySelector('.carousel-image');
                if (!carouselImage) return;

                // Ubah src image
                carouselImage.src = images[newIndex];
                carouselImage.dataset.index = newIndex;

                // Update dots
                const dots = carousel.querySelectorAll('.carousel-dot');
                dots.forEach((dot, i) => {
                    dot.style.backgroundColor = i === newIndex ? '#0d6efd' : '#dee2e6';
                });
            } catch (e) {
                console.error('Error updating carousel:', e);
            }
        }

        // Fungsi untuk mendapatkan lokasi pengguna
        document.getElementById('getLocationBtn').addEventListener('click', function() {
            if (navigator.geolocation) {
                // Tampilkan loading state pada tombol
                this.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mencari lokasi...';
                this.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Simpan lokasi pengguna dalam variabel global
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;

                        // Hapus marker sebelumnya jika ada
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }

                        // Tambahkan marker baru dengan custom icon dan efek animasi
                        userMarker = L.marker([userLat, userLng], {
                            title: 'Lokasi Anda'
                        }).addTo(map);

                        // Tambahkan popup ke marker dengan desain yang lebih menarik
                        userMarker.bindPopup(
                            '<div class="text-center p-2">' +
                            '<i class="bi bi-person-fill text-primary fs-4"></i>' +
                            '<h6 class="fw-bold mb-0 mt-1">Lokasi Anda</h6>' +
                            '<p class="text-muted small mb-0">Koordinat: ' + userLat.toFixed(4) + ', ' +
                            userLng.toFixed(4) + '</p>' +
                            '</div>'
                        ).openPopup();

                        // Pindahkan view peta ke lokasi pengguna dengan animasi
                        map.flyTo([userLat, userLng], 15, {
                            animate: true,
                            duration: 1.5
                        });

                        // Update semua popup dengan informasi jarak
                        updateAllPopupsWithDistance();

                        // Cari toko terdekat dan buka popup-nya
                        findNearestToko(userLat, userLng);

                        // Reset tombol dengan animasi
                        document.getElementById('getLocationBtn').innerHTML =
                            '<i class="bi bi-geo-alt-fill me-2"></i> Ambil Lokasi Saya';
                        document.getElementById('getLocationBtn').disabled = false;

                        // Tambahkan notifikasi sukses
                        showNotification('success', 'Lokasi berhasil ditemukan!');
                    },
                    function(error) {
                        // Handle error
                        let errorMessage;
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Anda menolak permintaan geolokasi.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Waktu permintaan untuk mendapatkan lokasi habis.";
                                break;
                            case error.UNKNOWN_ERROR:
                                errorMessage = "Terjadi kesalahan yang tidak diketahui.";
                                break;
                        }

                        // Tampilkan pesan error dengan notifikasi
                        showNotification('error', errorMessage);

                        // Reset tombol
                        document.getElementById('getLocationBtn').innerHTML =
                            '<i class="bi bi-geo-alt-fill me-2"></i> Ambil Lokasi Saya';
                        document.getElementById('getLocationBtn').disabled = false;
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showNotification('error', "Geolocation tidak didukung oleh browser Anda.");
            }
        });

        // Fungsi untuk menampilkan notifikasi
        function showNotification(type, message) {
            // Buat elemen notifikasi
            const notification = document.createElement('div');
            notification.className = 'notification ' + type;
            notification.innerHTML = `
    <div class="alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show shadow-sm" role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 10px;">
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}-fill me-2 fs-4"></i>
            <div>${message}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
`;

            // Tambahkan ke body
            document.body.appendChild(notification);

            // Hapus setelah 5 detik
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Fungsi untuk menemukan toko terdekat
        function findNearestToko(userLat, userLng) {
            let nearestToko = null;
            let nearestDistance = Infinity;
            let nearestMarkerIndex = -1;

            // Periksa semua marker untuk mencari yang terdekat
            tokoMarkers.forEach((marker, index) => {
                const lat = marker.getLatLng().lat;
                const lng = marker.getLatLng().lng;
                const distance = getDistance(userLat, userLng, lat, lng);

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestToko = {
                        lat: lat,
                        lng: lng
                    };
                    nearestMarkerIndex = index;
                }
            });

            if (nearestToko && nearestMarkerIndex >= 0) {
                // Buka popup marker terdekat
                tokoMarkers[nearestMarkerIndex].openPopup();

                // Tambahkan notifikasi
                const distanceText = formatDistance(nearestDistance);
                showNotification('success', `Toko terdekat ditemukan! Jarak: ${distanceText}`);
            }
        }
    </script>
</body>

</html>
