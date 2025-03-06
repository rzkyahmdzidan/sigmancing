<!-- Modal Edit Spot -->
<div class="modal fade" id="editSpotModal" tabindex="-1" aria-labelledby="editSpotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editSpotModalLabel">
                    <i class="bi bi-geo-alt-fill me-2"></i>Edit Spot
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editSpotForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_spot_id" name="spot_id">
                <!-- Tambahkan hidden input untuk menyimpan gambar yang sudah ada -->
                <input type="hidden" id="existing_images_input" name="existing_images">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nama Spot -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_nama_spot" name="nama_spot"
                                    required>
                                <label for="edit_nama_spot">Nama Spot</label>
                                <div class="invalid-feedback">
                                    Nama spot harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_lokasi" name="lokasi" required>
                                <label for="edit_lokasi">Lokasi</label>
                                <div class="invalid-feedback">
                                    Lokasi harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Koordinat -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Koordinat</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                        <input type="number" step="any" class="form-control" id="edit_latitude"
                                            name="latitude" placeholder="Latitude" required>
                                        <div class="invalid-feedback">
                                            Latitude harus diisi
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                        <input type="number" step="any" class="form-control" id="edit_longitude"
                                            name="longitude" placeholder="Longitude" required>
                                        <div class="invalid-feedback">
                                            Longitude harus diisi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Ikan -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="edit_jenis_ikan" name="jenis_ikan"
                                    required>
                                <label for="edit_jenis_ikan">Jenis Ikan</label>
                                <div class="invalid-feedback">
                                    Jenis ikan harus diisi
                                </div>
                            </div>
                        </div>

                        <!-- Rekomendasi -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Rekomendasi</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select" id="edit_rekomendasi_umpan"
                                            name="rekomendasi_umpan">
                                            <option value="" disabled selected>Pilih rekomendasi umpan</option>
                                            @foreach ($umpans as $umpan)
                                                <option value="{{ $umpan->id }}">
                                                    {{ $umpan->nama }} - {{ $umpan->kategori }} (Efektivitas:
                                                    {{ $umpan->efektivitas }}%)
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Rekomendasi umpan harus diisi
                                        </div>
                                        <small class="text-muted">Klik untuk memilih umpan</small>
                                        <!-- Ini akan menyimpan nilai multiple sebagai hidden input -->
                                        <div id="edit-hidden-umpan-container"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-cloud-sun"></i></span>
                                        <input type="text" class="form-control" id="edit_rekomendasi_cuaca"
                                            name="rekomendasi_cuaca" placeholder="Cuaca" required>
                                        <div class="invalid-feedback">
                                            Rekomendasi cuaca harus diisi
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
                                        <i class="bi bi-image me-2"></i>Gambar yang Ada
                                    </label>
                                    <div id="existing_images" class="mb-3">
                                        <!-- Gambar yang sudah ada akan ditampilkan di sini -->
                                    </div>

                                    <label for="edit_gambar" class="form-label fw-bold">
                                        <i class="bi bi-image me-2"></i>Tambah Gambar Baru
                                    </label>
                                    <input type="file" class="form-control" id="edit_gambar" name="gambar[]"
                                        accept="image/jpeg,image/png,image/gif" multiple>
                                    <div class="form-text">Format: JPG, PNG, GIF (Max: 2MB)</div>
                                    <div id="preview" class="mt-2">
                                        <!-- Preview gambar baru akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                <label for="edit_status">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .img-container {
        position: relative;
        display: inline-block;
        margin: 5px;
    }

    .img-container .delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container img {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
    }

    #preview img,
    #existing_images img {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        margin: 5px;
    }
</style>

<script>
    // Array untuk melacak gambar yang ada
    let existingImages = [];

    // Function untuk menampilkan alert debugging
    function debugAlert(message, data) {
        console.log(message, data);
        // Uncomment baris di bawah ini jika ingin melihat alert debugging
        // alert(message + ': ' + JSON.stringify(data));
    }

    // Preview gambar baru yang dipilih
    document.getElementById('edit_gambar').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear existing previews

        debugAlert("Files dipilih", {
            count: e.target.files.length,
            names: Array.from(e.target.files).map(f => f.name)
        });

        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            const imgContainer = document.createElement('div');
            imgContainer.className = 'd-inline-block position-relative m-2';

            const img = document.createElement('img');
            img.className = 'img-thumbnail';
            img.style.maxHeight = '200px';
            img.style.maxWidth = '200px';

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

        debugAlert("Display existing images", {
            images: images,
            type: typeof images
        });

        if (typeof images === 'string') {
            try {
                images = JSON.parse(images);
                debugAlert("Images after JSON parse", images);
            } catch (e) {
                console.error("Failed to parse images JSON", e);
                debugAlert("Failed to parse JSON", {
                    error: e.message,
                    images: images
                });
                images = [];
            }
        }

        // Set global existingImages
        existingImages = Array.isArray(images) ? [...images] : [];
        debugAlert("Set existingImages array", existingImages);

        // Update hidden input
        updateExistingImagesInput();

        if (!Array.isArray(images) || images.length === 0) {
            debugAlert("No images to display", {
                images: images
            });
            return;
        }

        images.forEach((image, index) => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'd-inline-block position-relative m-2';
            imgContainer.dataset.imageName = image; // Simpan nama gambar di atribut dataset

            const img = document.createElement('img');
            img.src = `/images/spots/${image}`;
            img.className = 'img-thumbnail';
            img.style.maxHeight = '200px';
            img.style.maxWidth = '200px';

            // Tambah tombol hapus
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
            deleteBtn.onclick = function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    // Hapus dari array existingImages
                    const imageIndex = existingImages.indexOf(image);
                    if (imageIndex > -1) {
                        existingImages.splice(imageIndex, 1);
                        debugAlert("Removed image from existingImages", {
                            removed: image,
                            newArray: existingImages
                        });
                    }

                    // Update hidden input
                    updateExistingImagesInput();

                    // Hapus dari tampilan
                    imgContainer.remove();

                    // Tambahkan input hidden untuk track gambar yang akan dihapus
                    const deletedInput = document.createElement('input');
                    deletedInput.type = 'hidden';
                    deletedInput.name = 'deleted_images[]';
                    deletedInput.value = image;
                    document.getElementById('editSpotForm').appendChild(deletedInput);
                }
            };

            imgContainer.appendChild(img);
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
                    // Saat form valid, tambahkan debug info
                    debugAlert("Form submission", {
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
        debugAlert("Edit spot called for ID", id);

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

        // Fetch spot data
        fetch(`/admin/spot/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                debugAlert("Received spot data", data);

                document.getElementById('edit_nama_spot').value = data.nama_spot;
                document.getElementById('edit_lokasi').value = data.lokasi;
                document.getElementById('edit_latitude').value = data.latitude;
                document.getElementById('edit_longitude').value = data.longitude;
                document.getElementById('edit_jenis_ikan').value = data.jenis_ikan;
                document.getElementById('edit_rekomendasi_umpan').value = data.rekomendasi_umpan;
                document.getElementById('edit_rekomendasi_cuaca').value = data.rekomendasi_cuaca;
                document.getElementById('edit_deskripsi').value = data.deskripsi;
                document.getElementById('edit_status').value = data.status ? '1' : '0';

                // Display existing images
                if (data.gambar) {
                    displayExistingImages(data.gambar);
                } else {
                    // Reset existingImages jika tidak ada gambar
                    existingImages = [];
                    updateExistingImagesInput();
                    debugAlert("No images in spot data", null);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data spot');
            });
    }
</script>
