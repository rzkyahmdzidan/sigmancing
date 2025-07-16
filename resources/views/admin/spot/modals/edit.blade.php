<!-- Modal Edit Spot -->
<div class="modal fade" id="editSpotModal" tabindex="-1" aria-labelledby="editSpotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editSpotModalLabel">
                    <i class="fas fa-map-marker-alt me-2"></i>Edit Spot
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editSpotForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_spot_id" name="spot_id">
                <input type="hidden" id="existing_images_input" name="existing_images">

                <div class="modal-body p-4">
                    <!-- Header Section -->
                    <div class="mb-4 border-bottom pb-2">
                        <h6 class="text-muted"><i class="fas fa-info-circle me-1"></i>Detail Spot</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Spot -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" id="edit_nama_spot" name="nama_spot"
                                    required>
                                <label for="edit_nama_spot"><i class="fas fa-tag me-1"></i>Nama Spot</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Nama spot harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi & Jenis Ikan -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" id="edit_lokasi" name="lokasi"
                                    required>
                                <label for="edit_lokasi"><i class="fas fa-map-pin me-1"></i>Lokasi</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Lokasi harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" id="edit_jenis_ikan"
                                    name="jenis_ikan" required>
                                <label for="edit_jenis_ikan"><i class="fas fa-fish me-1"></i>Jenis Ikan</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Jenis ikan harus diisi
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

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="my-2">
                        </div>

                        <!-- Rekomendasi Header -->
                        <div class="col-12 mb-0">
                            <h6 class="text-muted mb-2"><i class="fas fa-star me-1"></i>Rekomendasi</h6>
                        </div>

                        <!-- Rekomendasi Umpan & Cuaca -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Umpan</label>
                            <div class="form-group mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white"><i
                                            class="fas fa-search"></i></span>
                                    <select class="form-select bg-light" id="edit_rekomendasi_umpan"
                                        name="rekomendasi_umpan">
                                        <option value="" disabled selected>Pilih rekomendasi umpan</option>
                                        @foreach ($umpans as $umpan)
                                            <option value="{{ $umpan->id }}">
                                                {{ $umpan->nama }} - {{ $umpan->kategori }}
                                                ({{ $umpan->efektivitas }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="edit-hidden-umpan-container"></div>
                                <div class="form-text"><i class="fas fa-info-circle"></i> Klik untuk memilih umpan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Cuaca</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-info text-white"><i
                                        class="fas fa-cloud-sun"></i></span>
                                <input type="text" class="form-control bg-light" id="edit_rekomendasi_cuaca"
                                    name="rekomendasi_cuaca" placeholder="Rekomendasi cuaca" required>
                            </div>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> Rekomendasi cuaca harus diisi
                            </div>
                        </div>
                        <!-- Harga Parkir -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Harga Parkir</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-warning text-white"><i
                                        class="fas fa-parking"></i></span>
                                <input type="number" class="form-control bg-light" id="edit_harga_parkir"
                                    name="harga_parkir" placeholder="Masukkan harga parkir" min="0">
                            </div>
                            <div class="form-text"><i class="fas fa-info-circle"></i> Kosongkan jika gratis</div>
                        </div>
                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label small text-muted">Deskripsi</label>
                            <div class="form-floating">
                                <textarea class="form-control bg-light" id="edit_deskripsi" name="deskripsi" style="height: 100px" required></textarea>
                                <label for="edit_deskripsi"><i class="fas fa-align-left me-1"></i>Deskripsi
                                    detail</label>
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
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                <label for="edit_status"><i class="fas fa-toggle-on me-1"></i>Status spot</label>
                            </div>
                        </div>

                        <!-- Gambar Section -->
                        <div class="col-12 mt-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-images me-2"></i>Galeri Gambar
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
                                    <div id="preview" class="d-flex flex-wrap gap-2 mt-3">
                                        <!-- Preview gambar baru akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
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

    /* Preview gambar */
    #preview .img-container img,
    #existing_images .img-container img {
        width: 180px;
        height: 180px;
        object-fit: cover;
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
    // Array untuk melacak gambar yang ada
    let existingImages = [];

    // Preview gambar baru yang dipilih
    document.getElementById('edit_gambar').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear existing previews

        console.log("Files dipilih", {
            count: e.target.files.length,
            names: Array.from(e.target.files).map(f => f.name)
        });

        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            const imgContainer = document.createElement('div');
            imgContainer.className = 'img-container';

            const img = document.createElement('img');
            img.className = 'rounded';

            reader.onload = function(e) {
                img.src = e.target.result;
            }

            imgContainer.appendChild(img);
            preview.appendChild(imgContainer);
            reader.readAsDataURL(file);
        });
    });

    // Function untuk menampilkan gambar yang sudah ada
    function displayExistingImages(images) {
        const container = document.getElementById('existing_images');
        container.innerHTML = ''; // Clear existing content

        console.log("Display existing images", {
            images: images,
            type: typeof images
        });

        if (typeof images === 'string') {
            try {
                images = JSON.parse(images);
                console.log("Images after JSON parse", images);
            } catch (e) {
                console.error("Failed to parse images JSON", e);
                console.log("Failed to parse JSON", {
                    error: e.message,
                    images: images
                });
                images = [];
            }
        }

        // Set global existingImages
        existingImages = Array.isArray(images) ? [...images] : [];
        console.log("Set existingImages array", existingImages);

        // Update hidden input
        updateExistingImagesInput();

        if (!Array.isArray(images) || images.length === 0) {
            console.log("No images to display", {
                images: images
            });
            container.innerHTML =
                '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
            return;
        }

        images.forEach((image, index) => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'img-container';
            imgContainer.dataset.imageName = image; // Simpan nama gambar di atribut dataset

            const img = document.createElement('img');
            img.src = `/images/spots/${image}`;
            img.className = 'rounded';

            // Overlay untuk efek hover
            const overlay = document.createElement('div');
            overlay.className = 'position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10';

            // Tambah tombol hapus
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.title = 'Hapus gambar';
            deleteBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Konfirmasi dengan modal kecil
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    // Hapus dari array existingImages
                    const imageIndex = existingImages.indexOf(image);
                    if (imageIndex > -1) {
                        existingImages.splice(imageIndex, 1);
                        console.log("Removed image from existingImages", {
                            removed: image,
                            newArray: existingImages
                        });
                    }

                    // Update hidden input
                    updateExistingImagesInput();

                    // Hapus dari tampilan dengan animasi fade out
                    imgContainer.style.opacity = '0';
                    setTimeout(() => {
                        imgContainer.remove();

                        // Tampilkan pesan jika tidak ada gambar tersisa
                        if (existingImages.length === 0) {
                            container.innerHTML =
                                '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
                        }
                    }, 300);

                    // Tambahkan input hidden untuk track gambar yang akan dihapus
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_images[]';
                    deletedInput.value = image;
                    document.getElementById('editSpotForm').appendChild(deletedInput);
                }
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(overlay);
            imgContainer.appendChild(deleteBtn);
            container.appendChild(imgContainer);
        });
    }

    // Function untuk update hidden input dengan gambar yang ada
    function updateExistingImagesInput() {
        const inputElement = document.getElementById('existing_images_input');
        const jsonValue = JSON.stringify(existingImages);
        inputElement.value = jsonValue;
        console.log('Updated existing_images_input:', {
            value: jsonValue,
            array: existingImages
        });
    }

    // Form validation
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    console.log("Form submission", {
                        existingImages: existingImages,
                        inputValue: document.getElementById('existing_images_input').value,
                        hasNewFiles: document.getElementById('edit_gambar').files.length >
                            0,
                        fileCount: document.getElementById('edit_gambar').files.length
                    });
                }
                form.classList.add('was-validated');
            }, false)
        })
    })()

    // Reset input file ketika modal dibuka
    document.getElementById('editSpotModal').addEventListener('show.bs.modal', function() {
        document.getElementById('edit_gambar').value = '';
        document.getElementById('preview').innerHTML = '';
        console.log('Modal opened, file input reset');
    });

    // Function untuk mengisi form edit
    function editSpot(id) {
        console.log("Edit spot called for ID", id);

        const form = document.getElementById('editSpotForm');
        form.action = `/admin/spot/${id}`;
        document.getElementById('edit_spot_id').value = id;
        document.getElementById('preview').innerHTML = '';
        form.classList.remove('was-validated');

        // Reset form tapi jangan reset gambar
        const inputs = form.querySelectorAll('input:not([type="file"]), textarea, select');
        inputs.forEach(input => input.value = '');

        // Remove any existing deleted_images inputs
        form.querySelectorAll('input[name="deleted_images[]"]').forEach(input => input.remove());

        // Reset file input
        document.getElementById('edit_gambar').value = '';

        // Tampilkan loading indicator
        document.getElementById('existing_images').innerHTML =
            '<div class="d-flex justify-content-center w-100 py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        // Fetch spot data
        fetch(`/admin/spot/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                console.log("Received spot data", data);

                document.getElementById('edit_nama_spot').value = data.nama_spot;
                document.getElementById('edit_lokasi').value = data.lokasi;
                document.getElementById('edit_latitude').value = data.latitude;
                document.getElementById('edit_longitude').value = data.longitude;
                document.getElementById('edit_jenis_ikan').value = data.jenis_ikan;
                document.getElementById('edit_rekomendasi_cuaca').value = data.rekomendasi_cuaca;
                document.getElementById('edit_harga_parkir').value = data.harga_parkir || '';
                document.getElementById('edit_deskripsi').value = data.deskripsi;
                document.getElementById('edit_status').value = data.status ? '1' : '0';

                // Siapkan hidden input untuk rekomendasi_umpan
                const hiddenUmpanContainer = document.getElementById('edit-hidden-umpan-container');
                hiddenUmpanContainer.innerHTML = ''; // Clear previous inputs

                if (data.umpans && data.umpans.length > 0) {
                    document.getElementById('edit_rekomendasi_umpan').value = data.umpans[0].id;

                    data.umpans.forEach(umpan => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'rekomendasi_umpan[]';
                        hiddenInput.value = umpan.id;
                        hiddenUmpanContainer.appendChild(hiddenInput);
                    });
                }

                // Display existing images
                if (data.gambar) {
                    displayExistingImages(data.gambar);
                } else {
                    // Reset existingImages jika tidak ada gambar
                    existingImages = [];
                    updateExistingImagesInput();
                    document.getElementById('existing_images').innerHTML =
                        '<div class="alert alert-info w-100"><i class="fas fa-info-circle me-2"></i>Tidak ada gambar tersedia</div>';
                    console.log("No images in spot data");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('existing_images').innerHTML =
                    '<div class="alert alert-danger w-100"><i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan saat mengambil data</div>';
                alert('Terjadi kesalahan saat mengambil data spot');
            });
    }

    // Handler untuk dropdown rekomendasi_umpan
    document.getElementById('edit_rekomendasi_umpan').addEventListener('change', function() {
        var selectedValue = this.value;

        // Hapus hidden inputs sebelumnya
        document.getElementById('edit-hidden-umpan-container').innerHTML = '';

        // Jika nilai dipilih, buat hidden input
        if (selectedValue) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'rekomendasi_umpan[]';
            hiddenInput.value = selectedValue;
            document.getElementById('edit-hidden-umpan-container').appendChild(hiddenInput);
        }
    });
</script>
