<!-- Edit Toko Modal -->
<div class="modal fade" id="editTokoModal" tabindex="-1" aria-labelledby="editTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editTokoModalLabel">
                    <i class="fas fa-store me-2"></i>Edit Toko
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editTokoForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <!-- Header Section -->
                    <div class="mb-4 border-bottom pb-2">
                        <h6 class="text-muted"><i class="fas fa-info-circle me-1"></i>Informasi Toko</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Toko -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" id="edit_nama" name="nama"
                                    required>
                                <label for="edit_nama"><i class="fas fa-tag me-1"></i>Nama Toko</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Nama toko harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-light" id="edit_alamat" name="alamat" style="height: 100px" required></textarea>
                                <label for="edit_alamat"><i class="fas fa-map-marker-alt me-1"></i>Alamat</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Alamat harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Koordinat -->
                        <div class="col-md-12">
                            <label class="form-label text-primary fw-bold"><i
                                    class="fas fa-compass me-1"></i>Koordinat</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i
                                                class="fas fa-map-marker"></i></span>
                                        <input type="number" step="any" class="form-control bg-light"
                                            id="edit_latitude" name="latitude" placeholder="Latitude" required>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i> Latitude harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i
                                                class="fas fa-map-marker"></i></span>
                                        <input type="number" step="any" class="form-control bg-light"
                                            id="edit_longitude" name="longitude" placeholder="Longitude" required>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle"></i> Longitude harus diisi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" id="edit_no_telp" name="no_telp"
                                    required>
                                <label for="edit_no_telp"><i class="fas fa-phone me-1"></i>No. Telepon</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Nomor telepon harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="my-2">
                        </div>

                        <!-- Jam Operasional Header -->
                        <div class="col-12 mb-0">
                            <h6 class="text-muted mb-2"><i class="fas fa-clock me-1"></i>Jam Operasional</h6>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Jam Buka</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white"><i
                                        class="fas fa-door-open"></i></span>
                                <input type="time" class="form-control bg-light" id="edit_jam_buka" name="jam_buka"
                                    required>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Jam buka harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Jam Tutup</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white"><i
                                        class="fas fa-door-closed"></i></span>
                                <input type="time" class="form-control bg-light" id="edit_jam_tutup"
                                    name="jam_tutup" required>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Jam tutup harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12 mt-2">
                            <label class="form-label small text-muted">Deskripsi</label>
                            <div class="form-floating">
                                <textarea class="form-control bg-light" id="edit_deskripsi" name="deskripsi" style="height: 100px" required></textarea>
                                <label for="edit_deskripsi"><i class="fas fa-align-left me-1"></i>Deskripsi
                                    toko</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Deskripsi harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Status</label>
                            <div class="form-floating">
                                <select class="form-select bg-light" id="edit_status" name="status" required>
                                    <option value="1">Buka</option>
                                    <option value="0">Tutup</option>
                                </select>
                                <label for="edit_status"><i class="fas fa-toggle-on me-1"></i>Status toko</label>
                            </div>
                        </div>

                        <!-- Gambar Section -->
                        <div class="col-12 mt-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-images me-2"></i>Galeri Toko
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Existing Images -->
                                    <h6 class="mb-3 text-primary">
                                        <i class="fas fa-image me-1"></i>Gambar yang Ada
                                    </h6>
                                    <div id="existing_images" class="mb-4 d-flex flex-wrap gap-2">
                                        <!-- Gambar yang sudah ada akan ditampilkan di sini -->
                                    </div>

                                    <!-- Upload New Images -->
                                    <h6 class="mb-2 text-success">
                                        <i class="fas fa-upload me-1"></i>Tambah Gambar Baru
                                    </h6>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text bg-success text-white"><i
                                                class="fas fa-camera"></i></span>
                                        <input type="file" class="form-control" id="edit_gambar" name="gambar[]"
                                            accept="image/jpeg,image/png,image/gif" multiple>
                                    </div>
                                    <div class="form-text mb-2"><i class="fas fa-info-circle"></i> Format: JPG, PNG,
                                        GIF (Max: 2MB)</div>
                                    <div id="preview_edit" class="d-flex flex-wrap gap-2 mt-3">
                                        <!-- Preview gambar baru akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitEdit">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Style untuk kontainer gambar */
    .img-container {
        position: relative;
        display: inline-block;
        margin: 5px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .img-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    /* Style untuk tombol delete */
    .img-container .delete-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        opacity: 0;
        z-index: 2;
    }

    .img-container:hover .delete-btn {
        opacity: 1;
    }

    .img-container .delete-btn:hover {
        background: #c82333;
        transform: scale(1.1);
    }

    /* Style untuk gambar */
    .img-container img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .img-container:hover img {
        filter: brightness(0.9);
    }

    /* Form styling */
    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control,
    .form-select {
        border-radius: 6px;
    }

    .input-group-text {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    /* Transitions and animations */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        .img-container img {
            width: 140px;
            height: 140px;
        }
    }
</style>

<script>
    // Preview image for edit modal
    document.getElementById('edit_gambar').addEventListener('change', function(e) {
        const preview = document.getElementById('preview_edit');
        preview.innerHTML = '';

        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            const imgContainer = document.createElement('div');
            imgContainer.className = 'img-container';

            const img = document.createElement('img');
            img.className = 'rounded';

            reader.onload = function(e) {
                img.src = e.target.result;
            }

            // Overlay untuk efek hover
            const overlay = document.createElement('div');
            overlay.className = 'position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10';

            const removeBtn = document.createElement('button');
            removeBtn.className = 'delete-btn';
            removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
            removeBtn.title = 'Hapus gambar';
            removeBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                imgContainer.style.opacity = '0';
                setTimeout(() => {
                    imgContainer.remove();
                }, 300);
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(overlay);
            imgContainer.appendChild(removeBtn);
            preview.appendChild(imgContainer);
            reader.readAsDataURL(file);
        });
    });

    function displayExistingImages(images) {
        const container = document.getElementById('existing_images');
        container.innerHTML = '';

        if (typeof images === 'string') {
            try {
                images = JSON.parse(images);
            } catch (e) {
                console.error("Failed to parse images JSON", e);
                images = [];
            }
        }

        if (!Array.isArray(images) || images.length === 0) {
            container.innerHTML =
                '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
            return;
        }

        images.forEach((image, index) => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'img-container';

            const img = document.createElement('img');
            img.src = `/images/toko/${image}`;
            img.className = 'rounded';

            // Overlay untuk efek hover
            const overlay = document.createElement('div');
            overlay.className = 'position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10';

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.title = 'Hapus gambar';
            deleteBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    // Hapus dengan animasi fade out
                    imgContainer.style.opacity = '0';
                    setTimeout(() => {
                        imgContainer.remove();

                        // Tampilkan pesan jika tidak ada gambar tersisa
                        const remainingImages = container.querySelectorAll('.img-container');
                        if (remainingImages.length === 0) {
                            container.innerHTML =
                                '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
                        }
                    }, 300);

                    // Add to deleted images array
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_images[]';
                    deletedInput.value = image;
                    document.getElementById('editTokoForm').appendChild(deletedInput);
                }
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(overlay);
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

        // Tampilkan loading indicator
        document.getElementById('existing_images').innerHTML =
            '<div class="d-flex justify-content-center w-100 py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        // Remove any existing deleted_images inputs
        form.querySelectorAll('input[name="deleted_images[]"]').forEach(input => input.remove());

        // Disable submit button and show loading state
        const submitBtn = document.getElementById('btnSubmitEdit');
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';

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
                } else {
                    document.getElementById('existing_images').innerHTML =
                        '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
                }

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan Perubahan';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('existing_images').innerHTML =
                    '<div class="alert alert-danger w-100"><i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan saat mengambil data</div>';
                alert('Terjadi kesalahan saat mengambil data toko');

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan Perubahan';
            });
    }

    // Form validation
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
