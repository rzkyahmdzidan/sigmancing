<div class="modal fade" id="addSpotModal" tabindex="-1" aria-labelledby="addSpotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.spot.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSpotModalLabel">Tambah Spot Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Spot</label>
                        <input type="text" class="form-control" name="nama_spot" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" class="form-control" name="latitude" step="any" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" class="form-control" name="longitude" step="any" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Ikan</label>
                        <input type="text" class="form-control" name="jenis_ikan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekomendasi Umpan</label>
                        <select class="form-select" name="rekomendasi_umpan[]" id="rekomendasi_umpan">
                            <option value="" disabled selected>Pilih rekomendasi umpan</option>
                            @foreach ($umpans as $umpan)
                                <option value="{{ $umpan->id }}">
                                    {{ $umpan->nama }} - {{ $umpan->kategori }} (Efektivitas:
                                    {{ $umpan->efektivitas }}%)
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Klik untuk memilih umpan</small>
                        <!-- Ini akan menyimpan nilai multiple sebagai hidden input -->
                        <div id="hidden-umpan-container"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekomendasi Cuaca</label>
                        <textarea class="form-control" name="rekomendasi_cuaca" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (Bisa pilih lebih dari 1)</label>
                        <input type="file" class="form-control" name="gambar[]" multiple accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG, GIF (Max: 2MB per gambar)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Styling untuk Select2 */
        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
            height: auto !important;
        }

        .select2-container--default .select2-selection--multiple {
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #6c757d !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 5px 10px !important;
            margin-right: 5px !important;
            color: white !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            margin-right: 5px !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da !important;
        }

        .select2-results__option {
            padding: 8px 12px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #e9ecef !important;
            color: black !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #6c757d !important;
            color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handler untuk dropdown
            $('#rekomendasi_umpan').on('change', function() {
                var selectedValue = $(this).val();

                // Hapus hidden inputs sebelumnya
                $('#hidden-umpan-container').empty();

                // Jika nilai dipilih, buat hidden input
                if (selectedValue) {
                    var hiddenInput = $('<input type="hidden" name="rekomendasi_umpan[]" value="' +
                        selectedValue + '">');
                    $('#hidden-umpan-container').append(hiddenInput);
                }
            });

            // Reset saat modal ditutup
            $('#addSpotModal').on('hidden.bs.modal', function() {
                $('#rekomendasi_umpan').val('');
                $('#hidden-umpan-container').empty();
            });
        });
    </script>
@endpush
