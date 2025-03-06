<div class="modal fade" id="addTokoModal" tabindex="-1" aria-labelledby="addTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTokoModalLabel">
                    <i class="fas fa-store me-2"></i>Tambah Toko Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.toko.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nama Toko -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nama" name="nama" required>
                                <label for="nama">Nama Toko</label>
                                <div class="invalid-feedback">
                                    Nama toko harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="alamat" name="alamat" style="height: 100px" required></textarea>
                                <label for="alamat">Alamat</label>
                                <div class="invalid-feedback">
                                    Alamat harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Koordinat -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Koordinat</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="number" step="any" class="form-control" id="latitude"
                                               name="latitude" placeholder="Latitude" required>
                                        <div class="invalid-feedback">
                                            Latitude harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="number" step="any" class="form-control" id="longitude"
                                               name="longitude" placeholder="Longitude" required>
                                        <div class="invalid-feedback">
                                            Longitude harus diisi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                <label for="no_telp">No. Telepon</label>
                                <div class="invalid-feedback">
                                    Nomor telepon harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Jam Operasional</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" id="jam_buka" name="jam_buka" required>
                                        <label for="jam_buka">Jam Buka</label>
                                        <div class="invalid-feedback">
                                            Jam buka harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" id="jam_tutup" name="jam_tutup" required>
                                        <label for="jam_tutup">Jam Tutup</label>
                                        <div class="invalid-feedback">
                                            Jam tutup harus diisi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" style="height: 100px" required></textarea>
                                <label for="deskripsi">Deskripsi</label>
                                <div class="invalid-feedback">
                                    Deskripsi harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <label for="gambar" class="form-label fw-bold">
                                        <i class="fas fa-images me-2"></i>Gambar Toko
                                    </label>
                                    <input type="file" class="form-control" id="gambar" name="gambar[]"
                                           accept="image/jpeg,image/png,image/gif" multiple>
                                    <div class="form-text">Format: JPG, PNG, GIF (Max: 2MB per gambar)</div>
                                    <div id="preview_add" class="mt-2 d-flex flex-wrap gap-2">
                                        <!-- Preview gambar akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="1">Buka</option>
                                    <option value="0">Tutup</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image for add modal
document.getElementById('gambar').addEventListener('change', function(e) {
    const preview = document.getElementById('preview_add');
    preview.innerHTML = '';

    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        const imgContainer = document.createElement('div');
        imgContainer.className = 'position-relative';

        const img = document.createElement('img');
        img.className = 'img-thumbnail';
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';

        reader.onload = function(e) {
            img.src = e.target.result;
        }

        const removeBtn = document.createElement('button');
        removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = function() {
            imgContainer.remove();
        };

        imgContainer.appendChild(img);
        imgContainer.appendChild(removeBtn);
        preview.appendChild(imgContainer);
        reader.readAsDataURL(file);
    });
});

// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
