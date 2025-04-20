@extends('admin.layouts.app')
@section('title', 'Kelola Toko')

@section('content')
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title">
                <h1>Kelola Toko Pancing</h1>
                <p>Kelola dan monitor semua toko pancing</p>
            </div>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTokoModal">
                <i class="fas fa-plus"></i> Tambah Toko
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background: #4f46e5;">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $toko->count() }}</div>
                <div class="stat-label">Total Toko</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #16a34a;">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $toko->where('status', 1)->filter->is_open->count() }}</div>
                <div class="stat-label">Toko Buka</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #eab308;">
                <i class="fas fa-door-closed"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $toko->where('status', 1)->reject->is_open->count() }}</div>
                <div class="stat-label">Toko Tutup</div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.toko.index') }}" method="GET" class="search-filter-form">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                    placeholder="Cari toko...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="buka" {{ request('status') == 'buka' ? 'selected' : '' }}>Buka</option>
                                <option value="tutup" {{ request('status') == 'tutup' ? 'selected' : '' }}>Tutup</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Non-aktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.toko.index') }}" class="btn btn-light w-100">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>GAMBAR</th>
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th>KOORDINAT</th>
                    <th>NO. TELP</th>
                    <th>JAM OPERASIONAL</th>
                    <th>STATUS</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($toko as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="spot-image-cell">
                            @if ($item->gambar)
                                @php
                                    $gambarArray = json_decode($item->gambar);
                                    $firstImage = $gambarArray[0] ?? null;
                                @endphp
                                @if ($firstImage)
                                    <div class="spot-image-container" data-bs-toggle="modal"
                                        data-bs-target="#imagePreviewModal" data-images="{{ $item->gambar }}"
                                        data-spot-name="{{ $item->nama }}">
                                        <img src="{{ asset('images/toko/' . $firstImage) }}" alt="{{ $item->nama }}"
                                            class="spot-image">
                                        @if (count($gambarArray) > 1)
                                            <span class="image-counter-badge">
                                                +{{ count($gambarArray) - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="spot-image-container">
                                    <img src="{{ asset('images/toko/') }}" alt="Default" class="spot-image">
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="spot-name">{{ $item->nama }}</div>
                        </td>
                        <td>
                            <div class="spot-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $item->alamat }}
                            </div>
                        </td>
                        <td>
                            <div class="coordinates">
                                <i class="fas fa-compass"></i>
                                {{ $item->latitude }}, {{ $item->longitude }}
                            </div>
                        </td>
                        <td>{{ $item->no_telp }}</td>
                        <td>{{ $item->jam_buka }} - {{ $item->jam_tutup }}</td>
                        <td>
                            @if ($item->status)
                                <span class="badge {{ $item->is_open ? 'bg-success' : 'bg-warning' }}">
                                    {{ $item->is_open ? 'Buka' : 'Tutup' }}
                                </span>
                            @else
                                <span class="badge bg-danger">Non-aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editTokoModal" onclick="editToko({{ $item->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.toko.destroy', $item->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-store"></i>
                                <h4>Belum ada data toko</h4>
                                <p>Silakan tambahkan toko baru untuk mulai mengelola data toko pancing.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($toko->hasPages())
            <div class="pagination-wrapper">
                {{ $toko->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Preview Gambar -->
    <div class="modal fade image-preview-modal" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center position-relative">
                    <img src="" alt="Preview" class="modal-image">
                    <button class="image-nav prev" onclick="changeImage(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="image-nav next" onclick="changeImage(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="image-counter mt-2">
                        <span id="currentImageIndex">1</span>/<span id="totalImages">1</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.toko.modals.add')
    @include('admin.toko.modals.edit')
@endsection
@section('scripts')
    <script>
        // Image Preview Modal Handler
        let currentImages = [];
        let currentImageIndex = 0;

        const imagePreviewModal = document.getElementById('imagePreviewModal');
        if (imagePreviewModal) {
            imagePreviewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imagesAttr = button.getAttribute('data-images');
                const tokoName = button.getAttribute('data-spot-name');
                console.log('data-images attribute:', imagesAttr);

                const images = JSON.parse(imagesAttr);
                console.log('Parsed images:', images);
                currentImages = images;
                currentImageIndex = 0;

                const modalImage = this.querySelector('.modal-image');
                const modalTitle = this.querySelector('.modal-title');
                const currentIndexSpan = this.querySelector('#currentImageIndex');
                const totalImagesSpan = this.querySelector('#totalImages');

                // Gunakan path yang benar
                modalImage.src = `/images/toko/${images[0]}`; // atau sesuaikan dengan struktur folder Anda
                modalTitle.textContent = tokoName;
                currentIndexSpan.textContent = '1';
                totalImagesSpan.textContent = images.length;
                console.log(images.length);


                // Show/hide navigation buttons
                const prevButton = this.querySelector('.image-nav.prev');
                const nextButton = this.querySelector('.image-nav.next');

                prevButton.style.display = images.length > 1 ? 'flex' : 'none';
                nextButton.style.display = images.length > 1 ? 'flex' : 'none';
            });

            // Reset when modal is hidden
            imagePreviewModal.addEventListener('hidden.bs.modal', function() {
                currentImageIndex = 0;
                currentImages = [];
            });
        }

        function changeImage(direction) {
            currentImageIndex += direction;

            if (currentImageIndex >= currentImages.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = currentImages.length - 1;
            }

            const modal = document.getElementById('imagePreviewModal');
            const modalImage = modal.querySelector('.modal-image');
            const currentIndexSpan = modal.querySelector('#currentImageIndex');

            // Gunakan path yang benar
            modalImage.src = `/images/toko/${currentImages[currentImageIndex]}`;
            currentIndexSpan.textContent = (currentImageIndex + 1).toString();
        }
        currentIndexSpan.textContent = (currentImageIndex + 1).toString();


        // Handle keyboard navigation
        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('imagePreviewModal');
            if (!modal.classList.contains('show')) return;

            if (event.key === 'ArrowLeft') {
                changeImage(-1);
            } else if (event.key === 'ArrowRight') {
                changeImage(1);
            }
        });

        function editToko(id) {
            fetch(`/admin/toko/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nama').value = data.nama;
                    document.getElementById('edit_alamat').value = data.alamat;
                    document.getElementById('edit_latitude').value = data.latitude;
                    document.getElementById('edit_longitude').value = data.longitude;
                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    document.getElementById('edit_no_telp').value = data.no_telp;
                    document.getElementById('edit_jam_buka').value = data.jam_buka;
                    document.getElementById('edit_jam_tutup').value = data.jam_tutup;
                    document.getElementById('edit_status').checked = data.status;

                    // Set form action
                    document.getElementById('editTokoForm').action = `/admin/toko/${id}`;

                    // Tampilkan gambar yang ada
                    const currentImagesContainer = document.getElementById('currentImages');
                    if (currentImagesContainer && data.gambar) {
                        const images = JSON.parse(data.gambar);
                        currentImagesContainer.innerHTML = images.map(img => `
                    <div class="current-image">
                        <img src="/images/toko/${img}" class="img-thumbnail" width="100">
                    </div>
                `).join('');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data toko');
                });
        }

        // Preview gambar sebelum upload
        function previewImages(event, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        container.innerHTML += `
                    <div class="preview-image">
                        <img src="${e.target.result}" class="img-thumbnail" width="100">
                    </div>
                `;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
@endsection
