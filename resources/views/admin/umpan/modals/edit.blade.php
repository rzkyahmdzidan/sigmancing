<!-- Edit Umpan Modal -->
<div class="modal fade" id="editUmpanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-fish me-2"></i>Edit Rekomendasi Umpan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editUmpanForm" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <!-- Header Section -->
                    <div class="mb-4 border-bottom pb-2">
                        <h6 class="text-muted"><i class="fas fa-info-circle me-1"></i>Informasi Umpan</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Nama & Kategori -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" name="nama" id="edit_nama_umpan"
                                    required>
                                <label for="edit_nama_umpan"><i class="fas fa-tag me-1"></i>Nama Umpan</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Nama umpan harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-light" name="kategori" id="edit_kategori" required>
                                    <option value="Natural Bait">Natural Bait</option>
                                    <option value="Artificial Bait">Artificial Bait</option>
                                    <option value="Mix Bait">Mix Bait</option>
                                </select>
                                <label for="edit_kategori"><i class="fas fa-layer-group me-1"></i>Kategori</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Kategori harus dipilih
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Ikan & Jenis Air -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" name="jenis_ikan"
                                    id="edit_jenis_ikan" required placeholder="Contoh: Lele, Gurame">
                                <label for="edit_jenis_ikan"><i class="fas fa-fish me-1"></i>Jenis Ikan</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Jenis ikan harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-light" name="jenis_air" id="edit_jenis_air" required>
                                    <option value="Air Tawar">Air Tawar</option>
                                    <option value="Air Asin">Air Asin</option>
                                    <option value="Air Payau">Air Payau</option>
                                </select>
                                <label for="edit_jenis_air"><i class="fas fa-water me-1"></i>Jenis Air</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Jenis air harus dipilih
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="my-2">
                        </div>

                        <!-- Detail Section -->
                        <div class="col-12 mb-0">
                            <h6 class="text-muted mb-2"><i class="fas fa-clipboard-list me-1"></i>Detail & Status</h6>
                        </div>

                        <!-- Waktu Terbaik & Badge -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light" name="waktu_terbaik"
                                    id="edit_waktu_terbaik" required placeholder="Contoh: Pagi, Sore">
                                <label for="edit_waktu_terbaik"><i class="fas fa-clock me-1"></i>Waktu Terbaik</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> Waktu terbaik harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select bg-light" name="badge" id="edit_badge">
                                    <option value="">Tanpa Badge</option>
                                    <option value="Recommended">Recommended</option>
                                    <option value="Popular">Popular</option>
                                    <option value="Best Choice">Best Choice</option>
                                </select>
                                <label for="edit_badge"><i class="fas fa-award me-1"></i>Badge</label>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-light" name="deskripsi" id="edit_deskripsi" style="height: 120px"></textarea>
                                <label for="edit_deskripsi"><i class="fas fa-align-left me-1"></i>Deskripsi</label>
                            </div>
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Jelaskan detail tentang
                                umpan ini</div>
                        </div>

                        <!-- Status -->
                        <div class="col-12 mt-2">
                            <div class="card border-0 bg-light p-3">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status"
                                            value="1" id="editStatusSwitch" style="width: 50px; height: 25px;">
                                        <label class="form-check-label ms-2 fw-bold" for="editStatusSwitch">Status
                                            Aktif</label>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-success p-2" id="statusBadgeActive">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                        <span class="badge bg-danger p-2 d-none" id="statusBadgeInactive">
                                            <i class="fas fa-times-circle me-1"></i>Tidak Aktif
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted mt-2"><i class="fas fa-info-circle me-1"></i>Umpan yang tidak
                                    aktif tidak akan ditampilkan di halaman depan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitEditUmpan">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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

    /* Form switch styling */
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .form-switch .form-check-input {
        cursor: pointer;
        transition: background-position 0.15s ease-in-out, background-color 0.15s ease;
    }

    .form-switch .form-check-input:checked {
        background-position: right center;
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
</style>

<script>
    // Toggle status badge display based on switch state
    document.getElementById('editStatusSwitch').addEventListener('change', function() {
        const activeStatus = document.getElementById('statusBadgeActive');
        const inactiveStatus = document.getElementById('statusBadgeInactive');

        if (this.checked) {
            activeStatus.classList.remove('d-none');
            inactiveStatus.classList.add('d-none');
        } else {
            activeStatus.classList.add('d-none');
            inactiveStatus.classList.remove('d-none');
        }
    });

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

    // Function to fill form for editing
    function editUmpan(id) {
        const form = document.getElementById('editUmpanForm');
        form.action = `/admin/umpan/${id}`;
        form.classList.remove('was-validated');

        // Disable submit button and show loading state
        const submitBtn = document.getElementById('btnSubmitEditUmpan');
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';

        // Fetch umpan data
        fetch(`/admin/umpan/${id}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Fill form fields
                document.getElementById('edit_nama_umpan').value = data.nama;
                document.getElementById('edit_kategori').value = data.kategori;
                document.getElementById('edit_jenis_ikan').value = data.jenis_ikan;
                document.getElementById('edit_jenis_air').value = data.jenis_air;
                document.getElementById('edit_waktu_terbaik').value = data.waktu_terbaik;
                document.getElementById('edit_deskripsi').value = data.deskripsi;
                document.getElementById('edit_badge').value = data.badge || '';

                // Set status switch
                const statusSwitch = document.getElementById('editStatusSwitch');
                statusSwitch.checked = data.status == 1;

                // Toggle status badges
                const activeStatus = document.getElementById('statusBadgeActive');
                const inactiveStatus = document.getElementById('statusBadgeInactive');

                if (data.status == 1) {
                    activeStatus.classList.remove('d-none');
                    inactiveStatus.classList.add('d-none');
                } else {
                    activeStatus.classList.add('d-none');
                    inactiveStatus.classList.remove('d-none');
                }

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan Perubahan';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data umpan');

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan Perubahan';
            });
    }
</script>
