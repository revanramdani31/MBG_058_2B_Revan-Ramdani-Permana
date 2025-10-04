<?= $this->include('partials/header', ['title' => 'Tambah Bahan Baku']) ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3">Tambah Bahan Baku</h3>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>

                <?php $errors = session()->getFlashdata('errors') ?? [];?>

                <form id="createBahanForm" action="<?= site_url('/gudang/bahan/store') ?>" method="post" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= esc(old('nama')) ?>" required minlength="3">
                        <div class="invalid-feedback"><?= isset($errors['nama']) ? esc($errors['nama']) : '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control <?= isset($errors['kategori']) ? 'is-invalid' : '' ?>" id="kategori" name="kategori" value="<?= esc(old('kategori')) ?>" required>
                        <div class="invalid-feedback"><?= isset($errors['kategori']) ? esc($errors['kategori']) : '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control <?= isset($errors['jumlah']) ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" value="<?= esc(old('jumlah')) ?>" required min="0" step="1">
                        <div class="invalid-feedback"><?= isset($errors['jumlah']) ? esc($errors['jumlah']) : '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control <?= isset($errors['satuan']) ? 'is-invalid' : '' ?>" id="satuan" name="satuan" value="<?= esc(old('satuan')) ?>" required>
                        <div class="invalid-feedback"><?= isset($errors['satuan']) ? esc($errors['satuan']) : '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control <?= isset($errors['tanggal_masuk']) ? 'is-invalid' : '' ?>" id="tanggal_masuk" name="tanggal_masuk" value="<?= esc(old('tanggal_masuk')) ?>" required>
                        <div class="invalid-feedback"><?= isset($errors['tanggal_masuk']) ? esc($errors['tanggal_masuk']) : '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control <?= isset($errors['tanggal_kadaluarsa']) ? 'is-invalid' : '' ?>" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="<?= esc(old('tanggal_kadaluarsa')) ?>">
                        <div class="invalid-feedback"><?= isset($errors['tanggal_kadaluarsa']) ? esc($errors['tanggal_kadaluarsa']) : '' ?></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/gudang/dashboard" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Improved client-side inline validation
        const form = document.getElementById('createBahanForm');
        const clearValidation = () => {
            form.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('is-invalid');
                const fb = el.nextElementSibling;
                if (fb && fb.classList.contains('invalid-feedback')) fb.textContent = '';
            });
        };

        form.addEventListener('submit', function(e) {
            clearValidation();

            const nama = document.getElementById('nama').value.trim();
            const jumlah = document.getElementById('jumlah').value;
            const tanggalMasuk = document.getElementById('tanggal_masuk').value;

            const fieldErrors = {};

            if (nama.length < 3) fieldErrors.nama = 'Nama minimal 3 karakter';
            if (jumlah === '' || isNaN(jumlah) || parseInt(jumlah) < 0) fieldErrors.jumlah = 'Jumlah harus angka >= 0';
            if (!tanggalMasuk) fieldErrors.tanggal_masuk = 'Tanggal masuk wajib diisi';

            if (Object.keys(fieldErrors).length) {
                e.preventDefault();
                for (const k in fieldErrors) {
                    const el = document.getElementById(k);
                    if (!el) continue;
                    el.classList.add('is-invalid');
                    const fb = el.nextElementSibling;
                    if (fb && fb.classList.contains('invalid-feedback')) fb.textContent = fieldErrors[k];
                }
                // focus first invalid
                const first = form.querySelector('.is-invalid');
                if (first) first.focus();
            }
        });
    </script>

<?= $this->include('partials/footer') ?>
