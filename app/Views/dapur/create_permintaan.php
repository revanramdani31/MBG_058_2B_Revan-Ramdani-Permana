<?= $this->include('partials/header', ['title' => 'Buat Permintaan Bahan']) ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-3">Buat Permintaan Bahan (H-1)</h3>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>

            <form action="<?= site_url('/dapur/permintaan/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_masak" class="form-label">Tanggal Masak</label>
                            <input type="date"
                                class="form-control <?= isset($errors['tanggal_masak']) ? 'is-invalid' : '' ?>"
                                id="tanggal_masak" name="tanggal_masak" value="<?= esc(old('tanggal_masak')) ?>"
                                required>
                            <div class="invalid-feedback">
                                <?= isset($errors['tanggal_masak']) ? esc($errors['tanggal_masak']) : '' ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah_porsi" class="form-label">Jumlah Porsi</label>
                            <input type="number"
                                class="form-control <?= isset($errors['jumlah_porsi']) ? 'is-invalid' : '' ?>"
                                id="jumlah_porsi" name="jumlah_porsi" value="<?= esc(old('jumlah_porsi')) ?>" required
                                min="1">
                            <div class="invalid-feedback">
                                <?= isset($errors['jumlah_porsi']) ? esc($errors['jumlah_porsi']) : '' ?></div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="menu_makan" class="form-label">Menu yang akan dibuat</label>
                    <input type="text" class="form-control <?= isset($errors['menu_makan']) ? 'is-invalid' : '' ?>"
                        id="menu_makan" name="menu_makan" value="<?= esc(old('menu_makan')) ?>" required>
                    <div class="invalid-feedback"><?= isset($errors['menu_makan']) ? esc($errors['menu_makan']) : '' ?>
                    </div>
                </div>

                <hr>

                <h5>Daftar Bahan Baku yang diminta</h5>
                <div id="bahan-baku-container">
                    <div class="row bahan-baku-item mb-2">
                        <div class="col-md-6">
                            <select name="bahan_id[]" class="form-select" required>
                                <option value="">Pilih Bahan Baku</option>
                                <?php foreach ($bahan_baku as $bahan): ?>
                                    <option value="<?= $bahan['id'] ?>"><?= esc($bahan['nama']) ?> (Stok:
                                        <?= $bahan['jumlah'] ?>     <?= $bahan['satuan'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required
                                min="1">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-bahan-baku">Hapus</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-bahan-baku" class="btn btn-success btn-sm mt-2">Tambah Bahan</button>

                <hr>

                <button type="submit" class="btn btn-primary">Simpan Permintaan</button>
                <a href="/dapur/dashboard" class="btn btn-secondary ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('bahan-baku-container');
        const addButton = document.getElementById('add-bahan-baku');
        const bahanBakuOptions = `
        <option value="">Pilih Bahan Baku</option>
        <?php foreach ($bahan_baku as $bahan): ?>
            <option value="<?= $bahan['id'] ?>"><?= esc($bahan['nama']) ?> (Stok: <?= $bahan['jumlah'] ?> <?= $bahan['satuan'] ?>)</option>
        <?php endforeach; ?>
    `;

        addButton.addEventListener('click', function () {
            const newItem = document.createElement('div');
            newItem.classList.add('row', 'bahan-baku-item', 'mb-2');
            newItem.innerHTML = `
            <div class="col-md-6">
                <select name="bahan_id[]" class="form-select" required>
                    ${bahanBakuOptions}
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required min="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-bahan-baku">Hapus</button>
            </div>
        `;
            container.appendChild(newItem);
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-bahan-baku')) {
                e.target.closest('.bahan-baku-item').remove();
            }
        });
    });
</script>

<?= $this->include('partials/footer') ?>