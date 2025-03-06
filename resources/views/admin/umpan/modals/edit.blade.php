<!-- Edit Umpan Modal -->
<div class="modal fade" id="editUmpanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rekomendasi Umpan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editUmpanForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Umpan</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="Natural Bait">Natural Bait</option>
                            <option value="Artificial Bait">Artificial Bait</option>
                            <option value="Mix Bait">Mix Bait</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Ikan</label>
                        <input type="text" class="form-control" name="jenis_ikan" required
                               placeholder="Contoh: Lele, Gurame">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Air</label>
                        <select class="form-select" name="jenis_air" required>
                            <option value="Air Tawar">Air Tawar</option>
                            <option value="Air Asin">Air Asin</option>
                            <option value="Air Payau">Air Payau</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Terbaik</label>
                        <input type="text" class="form-control" name="waktu_terbaik" required
                               placeholder="Contoh: Pagi, Sore">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Badge</label>
                        <select class="form-select" name="badge">
                            <option value="">Tanpa Badge</option>
                            <option value="Recommended">Recommended</option>
                            <option value="Popular">Popular</option>
                            <option value="Best Choice">Best Choice</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status"
                                   value="1" id="editStatusSwitch">
                            <label class="form-check-label" for="editStatusSwitch">Status Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
