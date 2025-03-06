@extends('admin.layouts.app')
@section('title', 'Kelola Spot')

@section('content')
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title">
                <h1>Kelola Spot Memancing</h1>
                <p>Kelola dan monitor semua lokasi spot memancing</p>
            </div>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addSpotModal">
                <i class="fas fa-plus"></i> Tambah Spot
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $spots->total() }}</h3>
                <span class="stat-label">Total Spot</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $spots->where('status', 1)->count() }}</h3>
                <span class="stat-label">Spot Aktif</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $spots->where('status', 0)->count() }}</h3>
                <span class="stat-label">Spot Non-Aktif</span>
            </div>
        </div>

    </div>

    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.spot.index') }}" method="GET" class="search-filter-form">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                    placeholder="Cari spot memancing...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="lokasi">
                                <option value="">Semua Lokasi</option>
                                @foreach ($spots as $spot)
                                    <option value="{{ $spot->lokasi }}"
                                        {{ request('lokasi') == $spot->lokasi ? 'selected' : '' }}>
                                        {{ $spot->lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="status">
                                <option value="">Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
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
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Spot</th>
                    <th>Lokasi</th>
                    <th>Koordinat</th>
                    <th>Jenis Ikan</th>
                    <th>Rekomendasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spots as $spot)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="spot-image-cell">
                            @php $gambarArray = json_decode($spot->gambar) ?? []; @endphp
                            @if (count($gambarArray) > 0)
                                <div class="spot-image-container" data-bs-toggle="modal" data-bs-target="#imagePreviewModal"
                                    data-images="{{ json_encode($gambarArray) }}" data-spot-name="{{ $spot->nama_spot }}">
                                    <img src="{{ asset('images/spots/' . $gambarArray[0]) }}" alt="{{ $spot->nama_spot }}"
                                        class="spot-image">
                                </div>
                            @else
                                <div class="spot-image-container">
                                    <img src="{{ asset('images/default-spot.jpg') }}" alt="Default" class="spot-image">
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="spot-name">{{ $spot->nama_spot }}</div>
                        </td>
                        <td>
                            <div class="spot-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $spot->lokasi }}
                            </div>
                        </td>
                        <td>
                            <div class="coordinates">
                                <i class="fas fa-compass"></i>
                                {{ $spot->latitude }}, {{ $spot->longitude }}
                            </div>
                        </td>
                        <td>{{ $spot->jenis_ikan }}</td>
                        <td>
                            <div class="recommendations">
                                <div class="recommendation-item">
                                    <i class="fas fa-fish"></i>
                                    {{ $spot->rekomendasi_umpan }}
                                </div>
                                <div class="recommendation-item">
                                    <i class="fas fa-cloud"></i>
                                    {{ $spot->rekomendasi_cuaca }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $spot->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $spot->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editSpotModal"
                                    data-spot="{{ json_encode($spot) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.spot.destroy', $spot) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus spot ini?')">
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
                                <i class="fas fa-fish"></i>
                                <h4>Tidak ada data spot</h4>
                                <p>Silakan tambah spot baru untuk mulai mengelola lokasi memancing.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($spots->hasPages())
            <div class="pagination-wrapper">
                {{ $spots->withQueryString()->links() }}
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

    @include('admin.spot.modals.add')
    @include('admin.spot.modals.edit')
@endsection

@section('scripts')
    <script>
        // Edit Modal Handler
        const editModal = document.getElementById('editSpotModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const spotData = JSON.parse(button.getAttribute('data-spot'));

                const form = editModal.querySelector('form');
                form.querySelector('[name="nama_spot"]').value = spotData.nama_spot;
                form.querySelector('[name="lokasi"]').value = spotData.lokasi;
                form.querySelector('[name="latitude"]').value = spotData.latitude;
                form.querySelector('[name="longitude"]').value = spotData.longitude;
                form.querySelector('[name="deskripsi"]').value = spotData.deskripsi;
                form.querySelector('[name="jenis_ikan"]').value = spotData.jenis_ikan;
                form.querySelector('[name="rekomendasi_umpan"]').value = spotData.rekomendasi_umpan;
                form.querySelector('[name="rekomendasi_cuaca"]').value = spotData.rekomendasi_cuaca;
                form.querySelector('[name="status"]').value = spotData.status;

                form.action = `/admin/spot/${spotData.id}`;
            });
        }

        // Image Preview Modal Handler
        let currentImages = [];
        let currentImageIndex = 0;

        const imagePreviewModal = document.getElementById('imagePreviewModal');
        if (imagePreviewModal) {
            imagePreviewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const images = JSON.parse(button.getAttribute('data-images'));
                const spotName = button.getAttribute('data-spot-name');

                currentImages = images;
                currentImageIndex = 0;

                const modalImage = this.querySelector('.modal-image');
                const modalTitle = this.querySelector('.modal-title');
                const currentIndexSpan = this.querySelector('#currentImageIndex');
                const totalImagesSpan = this.querySelector('#totalImages');

                modalImage.src = `/images/spots/${images[0]}`;
                modalTitle.textContent = spotName;
                currentIndexSpan.textContent = '1';
                totalImagesSpan.textContent = images.length;

                // Show/hide navigation buttons
                const prevButton = this.querySelector('.image-nav.prev');
                const nextButton = this.querySelector('.image-nav.next');

                prevButton.style.display = images.length > 1 ? 'flex' : 'none';
                nextButton.style.display = images.length > 1 ? 'flex' : 'none';
            });
        }

        function changeImage(direction) {
            const modal = document.getElementById('imagePreviewModal');
            const modalImage = modal.querySelector('.modal-image');
            const currentIndexSpan = modal.querySelector('#currentImageIndex');

            currentImageIndex += direction;

            // Handle circular navigation
            if (currentImageIndex >= currentImages.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = currentImages.length - 1;
            }

            modalImage.src = `/images/spots/${currentImages[currentImageIndex]}`;
            currentIndexSpan.textContent = currentImageIndex + 1;
        }
    </script>
@endsection
