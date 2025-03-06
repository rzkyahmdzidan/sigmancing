<!-- Edit Toko Modal -->
<div class="modal fade" id="editTokoModal" tabindex="-1" aria-labelledby="editTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editTokoModalLabel">
                    <i class="fas fa-store me-2"></i>Edit Toko
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTokoForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nama Toko -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                <label for="edit_nama">Nama Toko</label>
                                <div class="invalid-feedback">
                                    Nama toko harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="edit_alamat" name="alamat" style="height: 100px" required></textarea>
                                <label for="edit_alamat">Alamat</label>
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
                                        <input type="number" step="any" class="form-control" id="edit_latitude"
                                               name="latitude" placeholder="Latitude" required>
                                        <div class="invalid-feedback">
                                            Latitude harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="number" step="any" class="form-control" id="edit_longitude"
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
                                <input type="text" class="form-control" id="edit_no_telp" name="no_telp" required>
                                <label for="edit_no_telp">No. Telepon</label>
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
                                        <input type="time" class="form-control" id="edit_jam_buka" name="jam_buka" required>
                                        <label for="edit_jam_buka">Jam Buka</label>
                                        <div class="invalid-feedback">
                                            Jam buka harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" id="edit_jam_tutup" name="jam_tutup" required>
                                        <label for="edit_jam_tutup">Jam Tutup</label>
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
                                <textarea class="form-control" id="edit_deskripsi" name="deskripsi" style="height: 100px" required></textarea>
                                <label for="edit_deskripsi">Deskripsi</label>
                                <div class="invalid-feedback">
                                    Deskripsi harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-images me-2"></i>Gambar yang Ada
                                    </label>
                                    <div id="existing_images" class="mb-3 d-flex flex-wrap gap-2">
                                        <!-- Gambar yang sudah ada akan ditampilkan di sini -->
                                    </div>

                                    <label for="edit_gambar" class="form-label fw-bold">
                                        <i class="fas fa-upload me-2"></i>Tambah Gambar Baru
                                    </label>
                                    <input type="file" class="form-control" id="edit_gambar" name="gambar[]"
                                           accept="image/jpeg,image/png,image/gif" multiple>
                                    <div class="form-text">Format: JPG, PNG, GIF (Max: 2MB)</div>
                                    <div id="preview_edit" class="mt-2 d-flex flex-wrap gap-2">
                                        <!-- Preview gambar baru akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="1">Buka</option>
                                    <option value="0">Tutup</option>
                                </select>
                                <label for="edit_status">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitEdit">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image for edit modal
document.getElementById('edit_gambar').addEventListener('change', function(e) {
    const preview = document.getElementById('preview_edit');
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

function displayExistingImages(images) {
    const container = document.getElementById('existing_images');
    container.innerHTML = '';

    if (typeof images === 'string') {
        images = JSON.parse(images);
    }

    if (!Array.isArray(images) || images.length === 0) {
        return;
    }

    images.forEach((image, index) => {
        const imgContainer = document.createElement('div');
        imgContainer.className = 'position-relative';

        const img = document.createElement('img');
        img.src = `/images/toko/${image}`;
        img.className = 'img-thumbnail';
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
        deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
        deleteBtn.onclick = function(e) {
            e.preventDefault();
            if(confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                imgContainer.remove();
                // Add to deleted images array
                const deletedInput = document.createElement('input');
                deletedInput.type = 'hidden';
                deletedInput.name = 'deleted_images[]';
                deletedInput.value = image;
                document.getElementById('editTokoForm').appendChild(deletedInput);
            }
        };

        imgContainer.appendChild(img);
        imgContainer.appendChild(deleteBtn);
        container.appendChild(imgContainer);
    });
}

function editToko(id) {
    const form = document.getElementById('editTokoForm');
    form.action = `/admin/toko/${id}`;
    form.classList.remove('was-validated');

    // Reset form
    form.reset();
    document.getElementById('preview_edit').innerHTML = '';
    document.getElementById('existing_images').innerHTML = '';

    // Disable submit button and show loading state
    const submitBtn = document.getElementById('btnSubmitEdit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';

    // Fetch toko data
    fetch(`/admin/toko/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_alamat').value = data.alamat;
            document.getElementById('edit_latitude').value = data.latitude;
            document.getElementById('edit_longitude').value = data.longitude;
            document.getElementById('edit_no_telp').value = data.no_telp;
            document.getElementById('edit_jam_buka').value = data.jam_buka;
            document.getElementById('edit_jam_tutup').value = data.jam_tutup;
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_status').value = data.status ? '1' : '0';

            if (data.gambar) {
                displayExistingImages(data.gambar);
            }

            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data toko');

            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
        });
}

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
