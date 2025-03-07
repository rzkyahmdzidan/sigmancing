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
        <h2 class="text-center mb-3">Peta Toko Pancing</h2>
        <p class="text-center mb-4">Berikut adalah informasi lokasi toko pancing terbaik di sekitar Anda.</p>

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
    <script>
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

        // Modifikasi fungsi createPopupContent untuk menambahkan tombol rute
        function createPopupContent(toko, includeDistance = false) {
            let content = '<div class="popup-content" style="min-width: 250px;">' +
                '<h5 style="font-size: 16px; font-weight: 600; color: #0d6efd; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">' +
                toko.name + '</h5>';

            // Informasi lokasi dengan ikon
            content += '<div style="margin-bottom: 6px;"><i class="bi bi-geo-alt" style="color: #666; width: 20px;"></i> ' +
                '<span style="color: #444;">' + toko.location + '</span></div>';

            // Format jam operasional yang lebih ringkas (menghilangkan detik)
            let openTimeFormatted = toko.open_time.split(':').slice(0, 2).join('.');
            let closeTimeFormatted = toko.close_time.split(':').slice(0, 2).join('.');

            // Informasi jam buka (tanpa status)
            content += '<div style="margin-bottom: 6px;"><i class="bi bi-clock" style="color: #666; width: 20px;"></i> ' +
                '<span style="color: #444;">' + openTimeFormatted + ' - ' + closeTimeFormatted + '</span></div>';

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

            // Tampilkan status dengan warna yang sesuai di bawah jam operasional
            content += '<div style="margin-bottom: 10px;">' +
                '<span class="status-badge" style="display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 12px; font-weight: 600; background-color: ' +
                (isOpen ? '#4CAF50' : '#F44336') + '; color: white;">' +
                (isOpen ? 'BUKA' : 'TUTUP') + '</span></div>';

            // Informasi telepon jika ada
            if (toko.phone) {
                content +=
                    '<div style="margin-bottom: 6px;"><i class="bi bi-telephone" style="color: #666; width: 20px;"></i> ' +
                    '<span style="color: #444;">' + toko.phone + '</span></div>';
            }

            // Tambahkan tombol untuk mendapatkan rute
            content += '<div style="margin: 10px 0;">' +
                '<button onclick="showRouteTo({lat: ' + toko.lat + ', lng: ' + toko.lng + ', name: \'' + toko.name +
                '\', location: \'' + toko.location + '\'})" ' +
                'class="btn btn-primary btn-sm" style="width: 100%;">' +
                '<i class="bi bi-signpost"></i> Dapatkan Rute</button></div>';

            // Tambahkan deskripsi jika ada
            if (toko.description) {
                content += '<div style="margin-bottom: 8px;"><span style="color: #444;">' + toko.description +
                    '</span></div>';
            }

            // Buat simple carousel
            if (toko.images && Array.isArray(toko.images) && toko.images.length > 0) {
                // Buat container sederhana
                content += '<div class="simple-carousel" style="margin: 10px 0;">';

                // Tampilkan gambar pertama saja (yang aktif)
                content += `<img src="${toko.images[0]}" class="carousel-image active" data-index="0"
                           style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">`;

                // Tambahkan navigasi dots
                if (toko.images.length > 1) {
                    content += '<div class="carousel-dots" style="text-align: center; margin-top: 5px;">';
                    for (let i = 0; i < toko.images.length; i++) {
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
                               data-images='${JSON.stringify(toko.images)}' data-total="${toko.images.length}"></div>`;
                }

                content += '</div>';
            } else if (toko.image) {
                // Fallback untuk single image
                content += '<img src="' + toko.image + '" class="img-fluid rounded my-2" alt="' + toko.name +
                    '" style="max-height: 150px; width: 100%; object-fit: cover;">';
            }

            // Jarak dari lokasi pengguna
            if (includeDistance && userLat !== null && userLng !== null) {
                const distance = getDistance(userLat, userLng, toko.lat, toko.lng);
                const distanceText = formatDistance(distance);
                content += '<div style="margin-top: 8px; border-top: 1px solid #ddd; padding-top: 8px;">' +
                    '<strong style="font-size: 13px;">Jarak dari lokasi Anda:</strong>' +
                    '<div style="font-size: 14px; color: #0d6efd; font-weight: 600;">' + distanceText + '</div></div>';
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
                        color: 'blue',
                        weight: 4
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

                // Update informasi rute
                var routeInfoHtml = `
        <div class="route-info-container">
            <h5>${toko.name}</h5>
            <p>Jarak: ${distanceString}, Waktu: ${timeString}</p>
            <p>Toko pancing di sekitar ${toko.location}</p>
            <div class="route-action-buttons">
                <button class="btn btn-primary btn-sm" onclick="window.open('https://www.google.com/maps/dir/?api=1&destination=${toko.lat},${toko.lng}', '_blank')">Dapatkan Arah</button>
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

                        // Cari toko terdekat dan buka popup-nya
                        findNearestToko(userLat, userLng);

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
            }
        }
    </script>
</body>

</html>
