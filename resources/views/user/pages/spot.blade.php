@extends('user.layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Spot Memancing</title>
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

        /* Styling untuk kontrol routing */
        .leaflet-routing-container {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            max-width: 350px;
            max-height: 300px;
            overflow-y: auto;
        }

        .leaflet-routing-alt {
            max-height: none !important;
        }

        .route-info-container {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        }

        .route-action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        /* CSS untuk carousel swipe */
        .carousel-container {
            position: relative;
            overflow: hidden;
            touch-action: pan-y;
            user-select: none;
            margin: 10px 0;
        }

        .carousel-dots {
            text-align: center;
            margin-top: 8px;
        }

        .carousel-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin: 0 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .map-type-control {
            background-color: #fff;
            border-radius: 4px;
            padding: 6px 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }

        .map-type-control .btn {
            margin-right: 5px;
            padding: 4px 8px;
            font-size: 12px;
        }

        .info-footer {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            margin-top: 20px;
            border-top: 1px solid #eee;
        }

        .info-section {
            text-align: center;
            flex: 1;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon {
            margin-right: 10px;
            color: #0d6efd;
        }

        .tips-section {
            display: flex;
            margin-top: 10px;
            justify-content: space-between;
        }

        .tip-item {
            display: flex;
            align-items: center;
            padding: 10px;
            flex: 1;
        }

        .tip-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('user.layouts.navbar')

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-md-11">
                <!-- Header -->
                <div class="text-center mb-3" data-aos="fade-down">
                    <h2 class="fw-bold">Peta Spot Memancing</h2>
                    <p class="text-muted">Berikut adalah informasi lokasi spot memancing terbaik di sekitar Anda.</p>
                </div>

                <!-- Location Button Row -->
                <div class="d-flex justify-content-between align-items-center mb-3" data-aos="fade-up">
                    <button class="btn btn-primary" id="getLocationBtn">
                        <i class="bi bi-geo-alt"></i> Ambil Lokasi Saya
                    </button>
                    <div class="map-type-control">
                        <button class="btn btn-sm btn-outline-secondary active" id="standardMapBtn">Peta
                            Standar</button>
                        <button class="btn btn-sm btn-outline-secondary" id="satelliteMapBtn">Satelit</button>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="mb-4" data-aos="zoom-in">
                    <div id="map"></div>
                </div>

                <!-- Info Footer -->
                <div class="info-footer" data-aos="fade-up">
                    <div class="info-section">
                        <div class="info-icon">
                            <i class="bi bi-water fs-4"></i>
                        </div>
                        <div class="text-start">
                            <div class="text-muted small">Jumlah Spot</div>
                            <div class="fw-bold">{{ count($spots) }} Spot</div>
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="info-icon">
                            <i class="bi bi-geo-alt fs-4"></i>
                        </div>
                        <div class="text-start">
                            <div class="text-muted small">Area Cakupan</div>
                            <div class="fw-bold">Sekitar Anda</div>
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="info-icon">
                            <i class="bi bi-info-circle fs-4"></i>
                        </div>
                        <div class="text-start">
                            <div class="text-muted small">Informasi Spot</div>
                            <div class="fw-bold">Lengkap & Akurat</div>
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="mt-4" data-aos="fade-up">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-lightbulb-fill"></i> Tips Mencari Spot Memancing
                    </h5>
                    <div class="tips-section">
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Gunakan Fitur Lokasi</div>
                                <p class="small text-muted">Aktifkan lokasi Anda untuk mendapatkan rekomendasi spot
                                    memancing terdekat.</p>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-signpost-split-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Dapatkan Rute</div>
                                <p class="small text-muted">Klik pada spot untuk mendapatkan petunjuk arah menuju
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
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Initialize map
        var map;
        var userMarker; // Variabel untuk menyimpan marker lokasi pengguna
        var spotMarkers = []; // Array untuk menyimpan semua marker spot
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
                maxZoom: 17, // Ubah dari 19 ke 17
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
        console.log("Data spots dari server:");
        @foreach ($spots as $spot)
            console.log({
                id: {{ $spot->id }},
                nama: "{{ $spot->nama_spot }}",
                umpan: "{{ $spot->rekomendasi_umpan }}",
                cuaca: "{{ $spot->rekomendasi_cuaca }}"
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

        // Modifikasi fungsi createPopupContent untuk menambahkan tombol rute
        // Modifikasi fungsi createPopupContent untuk tampilan yang lebih menarik
        function createPopupContent(spot, includeDistance = false) {
            let content = '<div class="popup-content" style="min-width: 260px;">' +
                '<h5 style="font-size: 17px; font-weight: 700; color: #0d6efd; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">' +
                spot.name + '</h5>';

            // Informasi lokasi dengan ikon
            content += '<div style="margin-bottom: 8px; display: flex;">' +
                '<i class="bi bi-geo-alt-fill" style="color: #dc3545; min-width: 24px; font-size: 16px;"></i> ' +
                '<span style="color: #333; font-size: 14px;">' + spot.location + '</span></div>';

            // Informasi jenis ikan dengan ikon
            content += '<div style="margin-bottom: 8px; display: flex;">' +
                '<i class="bi bi-water" style="color: #0d6efd; min-width: 24px; font-size: 16px;"></i> ' +
                '<span style="color: #333; font-size: 14px;">' + spot.fish + '</span></div>';

            // Informasi cocok untuk siapa
            if (spot.suitable) {
                content += '<div style="margin-bottom: 8px; display: flex;">' +
                    '<i class="bi bi-people-fill" style="color: #198754; min-width: 24px; font-size: 16px;"></i> ' +
                    '<span style="color: #333; font-size: 14px;">Cocok Untuk ' + spot.suitable + '</span></div>';
            } else {
                content += '<div style="margin-bottom: 8px; display: flex;">' +
                    '<i class="bi bi-people-fill" style="color: #198754; min-width: 24px; font-size: 16px;"></i> ' +
                    '<span style="color: #333; font-size: 14px;">Spot Memancing Umum</span></div>';
            }

            // Tambahkan tombol untuk mendapatkan rute dengan styling lebih menarik
            content += '<div style="margin: 15px 0;">' +
                '<button onclick="showRouteTo({lat: ' + spot.lat + ', lng: ' + spot.lng + ', name: \'' + spot.name +
                '\', location: \'' + spot.location + '\'})" ' +
                'class="btn btn-primary w-100 rounded-pill shadow-sm" style="font-weight: 600; padding: 8px 15px;">' +
                '<i class="bi bi-signpost-2-fill me-2"></i> Dapatkan Rute</button></div>';

            // Tambahkan deskripsi jika ada
            if (spot.description) {
                content +=
                    '<div style="margin: 12px 0; padding: 10px; background-color: #f8f9fa; border-radius: 8px; border-left: 3px solid #0d6efd;">' +
                    '<span style="color: #495057; font-size: 13px;">' + spot.description + '</span></div>';
            }

            // Buat carousel gambar yang lebih menarik
            if (spot.images && Array.isArray(spot.images) && spot.images.length > 0) {
                // Buat container dengan style yang lebih baik
                content +=
                    '<div class="simple-carousel" style="margin: 12px 0; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">';

                // Tampilkan gambar pertama saja (yang aktif)
                content += `<img src="${spot.images[0]}" class="carousel-image active" data-index="0"
                   style="width: 100%; height: 160px; object-fit: cover;">`;

                // Tambahkan navigasi dots yang lebih menarik
                if (spot.images.length > 1) {
                    content +=
                        '<div class="carousel-dots" style="text-align: center; margin: 8px 0; position: relative; bottom: 5px;">';
                    for (let i = 0; i < spot.images.length; i++) {
                        content +=
                            `<span class="carousel-dot" data-index="${i}"
                          style="display: inline-block; width: 8px; height: 8px; border-radius: 50%;
                          background-color: ${i === 0 ? '#0d6efd' : '#dee2e6'}; margin: 0 3px; transition: all 0.3s ease;"></span>`;
                    }
                    content += '</div>';

                    // Tambahkan data gambar untuk script (tersembunyi)
                    content += `<div class="carousel-data" style="display:none;"
                       data-images='${JSON.stringify(spot.images)}' data-total="${spot.images.length}"></div>`;
                }

                content += '</div>';
            } else if (spot.image) {
                // Fallback untuk single image dengan styling yang lebih baik
                content += '<img src="' + spot.image + '" class="img-fluid rounded my-2 shadow-sm" alt="' + spot.name +
                    '" style="max-height: 160px; width: 100%; object-fit: cover;">';
            }

            // Bagian rekomendasi dengan styling yang lebih menarik
            content += '<div style="background-color: #f8f9fa; border-radius: 8px; padding: 12px; margin-top: 15px;">';

            // Judul bagian rekomendasi
            content +=
                '<div style="margin-bottom: 10px; font-weight: 600; color: #0d6efd; font-size: 14px; border-bottom: 1px solid #e9ecef; padding-bottom: 5px;">' +
                '<i class="bi bi-info-circle-fill me-1"></i> Rekomendasi Memancing</div>';

            // Rekomendasi umpan
            content += '<div style="margin-bottom: 8px; display: flex;">' +
                '<i class="bi bi-egg-fill" style="color: #fd7e14; min-width: 24px; font-size: 16px;"></i> ' +
                '<div style="display: flex; flex-direction: column;">' +
                '<span style="font-size: 13px; color: #6c757d;">Rekomendasi Umpan:</span>' +
                '<span style="font-size: 14px; color: #212529; font-weight: 500;">' + (spot.bait ||
                    "Tidak ada rekomendasi") + '</span>' +
                '</div></div>';

            // Rekomendasi cuaca
            content += '<div style="margin-bottom: 5px; display: flex;">' +
                '<i class="bi bi-cloud-sun-fill" style="color: #6610f2; min-width: 24px; font-size: 16px;"></i> ' +
                '<div style="display: flex; flex-direction: column;">' +
                '<span style="font-size: 13px; color: #6c757d;">Rekomendasi Cuaca:</span>' +
                '<span style="font-size: 14px; color: #212529; font-weight: 500;">' + (spot.weather ||
                    "Tidak ada rekomendasi") + '</span>' +
                '</div></div>';

            // Jarak dari lokasi pengguna dengan styling yang lebih menarik
            if (includeDistance && userLat !== null && userLng !== null) {
                const distance = getDistance(userLat, userLng, spot.lat, spot.lng);
                const distanceText = formatDistance(distance);
                content += '<div style="margin-top: 12px; border-top: 1px solid #e9ecef; padding-top: 12px;">' +
                    '<div style="display: flex; align-items: center;">' +
                    '<i class="bi bi-pin-map-fill me-2" style="color: #6c757d; font-size: 16px;"></i>' +
                    '<span style="font-size: 13px; color: #495057;">Jarak dari lokasi Anda:</span>' +
                    '</div>' +
                    '<div style="font-size: 18px; color: #0d6efd; font-weight: 700; margin-top: 5px; text-align: center;">' +
                    distanceText + '</div></div>';
            }

            content += '</div></div>';
            return content;
        }

        // Fungsi untuk menampilkan rute ke spot memancing
        // Fungsi untuk menampilkan rute ke spot memancing
        function showRouteTo(spot) {
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
                    L.latLng(spot.lat, spot.lng)
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

            // Tambahkan info tentang spot di panel info rute
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
                <i class="bi bi-water text-primary me-2 fs-4"></i>
                <h5 class="mb-0 fw-bold">${spot.name}</h5>
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
            <p class="small text-muted mb-2">Lokasi: ${spot.location}</p>
            <div class="d-flex gap-2">
                <button class="btn btn-primary rounded-pill w-100" onclick="window.open('https://www.google.com/maps/dir/?api=1&destination=${spot.lat},${spot.lng}', '_blank')">
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

            // Data spot dari database
            const spots = [
                @foreach ($spots as $spot)
                    @if ($spot->latitude && $spot->longitude)
                        {
                            name: "{{ $spot->nama_spot }}",
                            location: "{{ $spot->lokasi }}",
                            fish: "{{ $spot->jenis_ikan }}",
                            description: "{{ Str::limit($spot->deskripsi, 100) }}",
                            suitable: "{{ $spot->cocok_untuk ?? 'Pemancing Umum' }}",
                            lat: {{ $spot->latitude }},
                            lng: {{ $spot->longitude }},
                            bait: "{{ trim($spot->rekomendasi_umpan) }}",
                            weather: "{{ trim($spot->rekomendasi_cuaca) }}",
                            @if ($spot->gambar)
                                <?php
                                $gambarArray = json_decode($spot->gambar, true);
                                $gambarArray = is_array($gambarArray) ? $gambarArray : [];
                                ?>
                                @if (count($gambarArray) > 0)
                                    image: "{{ asset('images/spots/' . $gambarArray[0]) }}",
                                    images: [
                                        @foreach ($gambarArray as $img)
                                            "{{ asset('images/spots/' . $img) }}",
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
            spots.forEach((spot, index) => {
                const popupContent = createPopupContent(spot, true);
                spotMarkers[spot.index].setPopupContent(popupContent);
            });
        }

        // Ambil data spot dari database dan tampilkan sebagai marker
        @if (isset($spots) && count($spots) > 0)
            @foreach ($spots as $spot)
                @if ($spot->latitude && $spot->longitude)
                    // Bagian pembuatan spotsData yang benar
                    var spotData = {
                        name: "{{ $spot->nama_spot }}",
                        location: "{{ $spot->lokasi }}",
                        fish: "{{ $spot->jenis_ikan }}",
                        description: "{{ Str::limit($spot->deskripsi, 100) }}",
                        suitable: "{{ $spot->cocok_untuk ?? 'Pemancing Umum' }}",
                        lat: {{ $spot->latitude }},
                        lng: {{ $spot->longitude }},
                        bait: "{{ $spot->rekomendasi_umpan }}",
                        weather: "{{ $spot->rekomendasi_cuaca }}",
                        @if ($spot->gambar)
                            <?php
                            $gambarArray = json_decode($spot->gambar, true);
                            $gambarArray = is_array($gambarArray) ? $gambarArray : [];
                            ?>
                            @if (count($gambarArray) > 0)
                                image: "{{ asset('images/spots/' . $gambarArray[0]) }}",
                                images: [
                                    @foreach ($gambarArray as $img)
                                        "{{ asset('images/spots/' . $img) }}",
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
                    var initialPopupContent = createPopupContent(spotData, false);

                    var marker = L.marker([spotData.lat, spotData.lng])
                        .bindPopup(initialPopupContent, {
                            minWidth: 250,
                            maxWidth: 300
                        });

                    marker.addTo(map);
                    spotMarkers.push(marker);

                    // Event listener untuk popup
                    marker.on('popupopen', function() {
                        setTimeout(function() {
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
                            var popupContent = createPopupContent(spotData, true);
                            marker.setPopupContent(popupContent);
                        }
                    });
                @endif
            @endforeach

            // Jika ada spot, atur tampilan peta untuk menampilkan semua spot
            @if (count($spots) > 0)
                // Membuat grup untuk semua marker spot
                var group = new L.featureGroup(spotMarkers);

                // Atur tampilan peta untuk menampilkan semua spot
                if (group && group.getBounds().isValid()) {
                    map.fitBounds(group.getBounds().pad(0.2));
                }
            @endif
        @else
            console.log("Tidak ada data spot yang tersedia.");
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
                    dot.style.backgroundColor = i === newIndex ? '#0d6efd' : '#ccc';
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

                        // Tambahkan marker baru
                        userMarker = L.marker([userLat, userLng], {
                            title: 'Lokasi Anda'
                        }).addTo(map);

                        // Tambahkan popup ke marker
                        userMarker.bindPopup('Anda berada di sini!').openPopup();

                        // Pindahkan view peta ke lokasi pengguna
                        map.setView([userLat, userLng], 15);

                        // Update semua popup dengan informasi jarak
                        updateAllPopupsWithDistance();

                        // Cari spot terdekat dan buka popup-nya
                        findNearestSpot(userLat, userLng);

                        // Reset tombol
                        document.getElementById('getLocationBtn').innerHTML =
                            '<i class="bi bi-geo-alt"></i> Ambil Lokasi Saya';
                        document.getElementById('getLocationBtn').disabled = false;
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
                        alert(errorMessage);

                        // Reset tombol
                        document.getElementById('getLocationBtn').innerHTML =
                            '<i class="bi bi-geo-alt"></i> Ambil Lokasi Saya';
                        document.getElementById('getLocationBtn').disabled = false;
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
            }
        });

        // Fungsi untuk menemukan spot terdekat
        function findNearestSpot(userLat, userLng) {
            let nearestSpot = null;
            let nearestDistance = Infinity;
            let nearestMarkerIndex = -1;

            // Periksa semua marker untuk mencari yang terdekat
            spotMarkers.forEach((marker, index) => {
                const lat = marker.getLatLng().lat;
                const lng = marker.getLatLng().lng;
                const distance = getDistance(userLat, userLng, lat, lng);

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestSpot = {
                        lat: lat,
                        lng: lng
                    };
                    nearestMarkerIndex = index;
                }
            });

            if (nearestSpot && nearestMarkerIndex >= 0) {
                // Buka popup marker terdekat
                spotMarkers[nearestMarkerIndex].openPopup();

                // Menampilkan notifikasi spot terdekat
                const distanceText = formatDistance(nearestDistance);
                showNotification('success', `Spot terdekat ditemukan! Jarak: ${distanceText}`);
            }
        }

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
    </script>
</body>

</html>
