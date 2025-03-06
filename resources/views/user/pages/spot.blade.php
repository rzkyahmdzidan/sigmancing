<!DOCTYPE html>
<html lang="en">
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    </script>
    <style>
        #map {
            height: 600px;
            width: 100%;
            border: none !important;
        }

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

        .leaflet-routing-geocoder input {
            width: 100%;
            padding: 5px;
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

        .leaflet-container {
            border: none !important;
            box-shadow: none !important;
        }

        .popup-content h5 {
            color: #333;
            margin-bottom: 8px;
        }

        .popup-content p {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .popup-content img {
            max-width: 100%;
            border-radius: 4px;
            margin: 8px 0;
        }

        /* CSS untuk carousel swipe */
        .carousel-container {
            position: relative;
            overflow: hidden;
            touch-action: pan-y;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            margin: 10px 0;
        }

        .carousel-slides {
            display: flex;
            transition: transform 0.3s ease;
            width: 100%;
        }

        .carousel-slide {
            min-width: 100%;
            flex: 0 0 auto;
        }

        .carousel-indicators {
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

        /* Memperbaiki masalah scrolling pada leaflet popup */
        .leaflet-popup-content {
            margin: 13px;
            touch-action: pan-y;
        }

        /* Style untuk control layer */
        .leaflet-control-layers {
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        }

        .leaflet-control-layers-toggle {
            background-size: 20px 20px;
        }

        .map-type-control {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            padding: 8px 10px;
            margin-bottom: 10px;
        }

        .map-type-control .btn {
            margin-right: 5px;
            padding: 4px 8px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    @include('user.layouts.navbar')
    <div class="container mt-4">
        <h2 class="text-center mb-3">Peta Spot Memancing</h2>
        <p class="text-center mb-4">Berikut adalah informasi lokasi spot memancing terbaik di sekitar Anda.</p>

        <div class="card shadow-sm mb-4" style="border: none; box-shadow: none;">
            <div class="card-body" style="border: none; padding: 0;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-primary" id="getLocationBtn">
                        <i class="bi bi-geo-alt"></i> Ambil Lokasi Saya
                    </button>
                    <div class="map-type-control">
                        <button class="btn btn-sm btn-outline-secondary active" id="standardMapBtn">Peta
                            Standar</button>
                        <button class="btn btn-sm btn-outline-secondary" id="satelliteMapBtn">Satelit</button>
                    </div>
                </div>
                <div id="map" style="border: none;"></div>
            </div>
        </div>
    </div>
    @include('user.layouts.footer')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/spot.js') }}"></script>
    <script>
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
        function createPopupContent(spot, includeDistance = false) {
            let content = '<div class="popup-content" style="min-width: 250px;">' +
                '<h5 style="font-size: 16px; font-weight: 600; color: #0d6efd; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">' +
                spot.name + '</h5>';

            // Informasi lokasi dengan ikon
            content += '<div style="margin-bottom: 6px;"><i class="bi bi-geo-alt" style="color: #666; width: 20px;"></i> ' +
                '<span style="color: #444;">' + spot.location + '</span></div>';

            // Informasi jenis ikan dengan ikon
            content += '<div style="margin-bottom: 6px;"><i class="bi bi-water" style="color: #666; width: 20px;"></i> ' +
                '<span style="color: #444;">' + spot.fish + '</span></div>';

            // Tambahkan tombol untuk mendapatkan rute
            content += '<div style="margin: 10px 0;">' +
                '<button onclick="showRouteTo({lat: ' + spot.lat + ', lng: ' + spot.lng + ', name: \'' + spot.name +
                '\', location: \'' + spot.location + '\'})" ' +
                'class="btn btn-primary btn-sm" style="width: 100%;">' +
                '<i class="bi bi-signpost"></i> Dapatkan Rute</button></div>';

            // Informasi cocok untuk siapa (bagian ini dan seterusnya tidak diubah)
            if (spot.suitable) {
                content += '<div style="margin-bottom: 8px;"><span style="color: #444;">Cocok Untuk ' + spot.suitable +
                    '</span></div>';
            } else {
                content += '<div style="margin-bottom: 8px;"><span style="color: #444;">Spot Memancing Umum</span></div>';
            }

            // Buat simple carousel
            if (spot.images && Array.isArray(spot.images) && spot.images.length > 0) {
                // Buat container sederhana
                content += '<div class="simple-carousel" style="margin: 10px 0;">';

                // Tampilkan gambar pertama saja (yang aktif)
                content += `<img src="${spot.images[0]}" class="carousel-image active" data-index="0"
                           style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">`;

                // Tambahkan navigasi dots
                if (spot.images.length > 1) {
                    content += '<div class="carousel-dots" style="text-align: center; margin-top: 5px;">';
                    for (let i = 0; i < spot.images.length; i++) {
                        content += `<span class="carousel-dot" data-index="${i}"
                                  style="display: inline-block; width: 8px; height: 8px; border-radius: 50%;
                                  background-color: ${i === 0 ? '#0d6efd' : '#ccc'}; margin: 0 3px;"></span>`;
                    }
                    content += '</div>';

                    // Tambahkan indikator jumlah gambar
                    content += `<div class="carousel-indicator" style="text-align: center; font-size: 12px; color: #666; margin: 5px 0;">
                             </div>`;

                    // Tambahkan data gambar untuk script (tersembunyi)
                    content += `<div class="carousel-data" style="display:none;"
                               data-images='${JSON.stringify(spot.images)}' data-total="${spot.images.length}"></div>`;
                }

                content += '</div>';
            } else if (spot.image) {
                // Fallback untuk single image
                content += '<img src="' + spot.image + '" class="img-fluid rounded my-2" alt="' + spot.name +
                    '" style="max-height: 150px; width: 100%; object-fit: cover;">';
            }

            // Bagian rekomendasi
            content += '<div style="background-color: #f8f9fa; border-radius: 4px; padding: 8px; margin-top: 10px;">';

            // Rekomendasi umpan
            content += '<div style="margin-bottom: 5px;"><strong style="font-size: 13px;">Rekomendasi Umpan:</strong>' +
                '<div style="font-size: 13px; color: #444;">' + (spot.bait || "Tidak ada rekomendasi") + '</div></div>';

            // Rekomendasi cuaca
            content += '<div style="margin-bottom: 5px;"><strong style="font-size: 13px;">Rekomendasi Cuaca:</strong>' +
                '<div style="font-size: 13px; color: #444;">' + (spot.weather || "Tidak ada rekomendasi") + '</div></div>';

            // Jarak dari lokasi pengguna
            if (includeDistance && userLat !== null && userLng !== null) {
                const distance = getDistance(userLat, userLng, spot.lat, spot.lng);
                const distanceText = formatDistance(distance);
                content += '<div style="margin-top: 8px; border-top: 1px solid #ddd; padding-top: 8px;">' +
                    '<strong style="font-size: 13px;">Jarak dari lokasi Anda:</strong>' +
                    '<div style="font-size: 14px; color: #0d6efd; font-weight: 600;">' + distanceText + '</div></div>';
            }

            content += '</div></div>';
            return content;
        }

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
                    L.latLng(spot.lat, spot.lng) // Ganti destLat, destLng dengan spot.lat dan spot.lng
                ],
                routeWhileDragging: true,
                lineOptions: {
                    styles: [{
                        color: 'blue',
                        weight: 4
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

                // Update informasi rute
                var routeInfoHtml = `
        <div class="route-info-container">
            <h5>${spot.name}</h5>
            <p>Jarak: ${distanceString}, Waktu: ${timeString}</p>
            <p>Tempat memancing di sekitar ${spot.location}</p>
            <p>Kondisi: Baik</p>
            <div class="route-action-buttons">
                <button class="btn btn-primary btn-sm" onclick="window.open('https://www.google.com/maps/dir/?api=1&destination=${spot.lat},${spot.lng}', '_blank')">Dapatkan Arah</button>
                <button class="btn btn-danger btn-sm" onclick="clearRoute()">Batal Rute</button>
            </div>
        </div>
        `;

                // Tambahkan ke dalam container routing
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
            }
        }
    </script>
</body>

</html>
