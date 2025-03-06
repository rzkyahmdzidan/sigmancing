@extends('admin.layouts.app')
@section('title', 'Rekomendasi Umpan')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Rekomendasi Umpan</h1>
            <p class="text-muted">Kelola dan monitor rekomendasi umpan untuk berbagai jenis ikan</p>
        </div>
        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addUmpanModal">
            <i class="fas fa-plus me-2"></i>Tambah Rekomendasi
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.umpan.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                               name="search" value="{{ request('search') }}"
                               placeholder="Cari umpan...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="jenis_ikan">
                        <option value="">Semua Jenis Ikan</option>
                        @foreach($umpans->pluck('jenis_ikan')->unique() as $jenis)
                            <option value="{{ $jenis }}"
                                    {{ request('jenis_ikan') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="jenis_air">
                        <option value="">Jenis Air</option>
                        @foreach($umpans->pluck('jenis_air')->unique() as $air)
                            <option value="{{ $air }}"
                                    {{ request('jenis_air') == $air ? 'selected' : '' }}>
                                {{ $air }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Umpan Cards -->
    <div class="row">
        @forelse($umpans as $umpan)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $umpan->nama }}</h5>
                            <span class="badge bg-primary">{{ $umpan->kategori }}</span>
                        </div>
                        @if($umpan->badge)
                            <span class="badge bg-warning">{{ $umpan->badge }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-fish text-primary me-2"></i>
                            <span>{{ $umpan->jenis_ikan }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-water text-info me-2"></i>
                            <span>{{ $umpan->jenis_air }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span>{{ $umpan->waktu_terbaik }}</span>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-outline-primary"
                                onclick="editUmpan({{ $umpan->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.umpan.destroy', $umpan->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus umpan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-fish fa-3x text-muted mb-3"></i>
                <h4>Belum ada data umpan</h4>
                <p class="text-muted">Silakan tambahkan rekomendasi umpan baru.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Include Modals -->
@include('admin.umpan.modals.add')
@include('admin.umpan.modals.edit')

@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
</style>
@endpush

@section('scripts')
<script>
function editUmpan(id) {
    fetch(`/admin/umpan/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            const editModal = document.getElementById('editUmpanModal');
            // Set form values
            editModal.querySelector('[name="nama"]').value = data.nama;
            editModal.querySelector('[name="kategori"]').value = data.kategori;
            editModal.querySelector('[name="jenis_ikan"]').value = data.jenis_ikan;
            editModal.querySelector('[name="jenis_air"]').value = data.jenis_air;
            editModal.querySelector('[name="waktu_terbaik"]').value = data.waktu_terbaik;
            editModal.querySelector('[name="deskripsi"]').value = data.deskripsi;
            editModal.querySelector('[name="badge"]').value = data.badge;
            editModal.querySelector('[name="status"]').checked = data.status;

            // Set form action
            editModal.querySelector('form').action = `/admin/umpan/${data.id}`;

            // Show modal
            new bootstrap.Modal(editModal).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data');
        });
}
</script>
@endsection
