<?= $this->include('partials/header', ['title' => 'Konfirmasi Hapus Bahan']) ?>

<div class="container mt-4">
    <h3>Konfirmasi Hapus Bahan Baku</h3>

    <?php if (empty($item)): ?>
        <div class="alert alert-warning">Data bahan tidak ditemukan.</div>
    <?php else: ?>
        <div class="alert alert-info">
            Pastikan Anda yakin. Sistem hanya mengizinkan penghapusan bahan baku yang berstatus <strong>Kadaluarsa</strong>.
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9"><?= esc($item['nama']) ?></dd>

                    <dt class="col-sm-3">Kategori</dt>
                    <dd class="col-sm-9"><?= esc($item['kategori']) ?></dd>

                    <dt class="col-sm-3">Jumlah</dt>
                    <dd class="col-sm-9"><?= esc($item['jumlah']) ?>     <?= esc($item['satuan']) ?></dd>

                    <dt class="col-sm-3">Tgl Masuk</dt>
                    <dd class="col-sm-9"><?= esc($item['tanggal_masuk']) ?></dd>

                    <dt class="col-sm-3">Tgl Kadaluarsa</dt>
                    <dd class="col-sm-9"><?= esc($item['tanggal_kadaluarsa']) ?></dd>

                    <dt class="col-sm-3">Status</dt>
                    <?php $s = $item['computed_status'] ?? ($item['status'] ?? 'Tersedia'); ?>
                    <dd class="col-sm-9">
                        <?php if ($s === 'Kadaluarsa'): ?>
                            <span class="badge bg-danger">Kadaluarsa</span>
                        <?php elseif ($s === 'Segera Kadaluarsa'): ?>
                            <span class="badge bg-warning text-dark">Segera Kadaluarsa</span>
                        <?php elseif ($s === 'Habis'): ?>
                            <span class="badge bg-secondary">Habis</span>
                        <?php else: ?>
                            <span class="badge bg-success">Tersedia</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </div>

        <?php if (strcasecmp($s, 'Kadaluarsa') !== 0): ?>
            <div class="alert alert-danger">
                Bahan baku ini <strong>tidak dapat dihapus</strong> karena status bukan Kadaluarsa.
            </div>
            <a href="<?= site_url('gudang/dashboard') ?>" class="btn btn-secondary">Kembali</a>
        <?php else: ?>
            <div id="notif" class="my-2" style="display:none"></div>
            <form id="deleteForm" method="post" action="<?= site_url('gudang/bahan/' . $item['id'] . '/delete') ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Hapus</button>
                <a href="<?= site_url('gudang/dashboard') ?>" class="btn btn-secondary">Batal</a>
            </form>
            <script>
                (function () {
                    const form = document.getElementById('deleteForm');
                    const notif = document.getElementById('notif');
                    function showAlert(message, type) {
                        notif.className = 'alert alert-' + type + ' my-2';
                        notif.textContent = message;
                        notif.style.display = 'block';
                    }
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const ok = confirm('Hapus bahan <?= addslashes($item['nama']) ?>? Tindakan ini tidak dapat dibatalkan.');
                        if (!ok) return;

                        const formData = new FormData(form);
                        fetch(form.action, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json' },
                            body: formData
                        })
                            .then(res => res.json().catch(() => ({ success: false, message: 'Gagal memproses respons server.' })))
                            .then(data => {
                                if (data.success) {
                                    showAlert(data.message || 'Bahan baku berhasil dihapus.', 'success');
                                    setTimeout(() => { window.location.href = '<?= site_url('gudang/dashboard') ?>'; }, 1000);
                                } else {
                                    showAlert(data.message || 'Bahan baku tidak dapat dihapus.', 'danger');
                                }
                            })
                            .catch(() => showAlert('Terjadi kesalahan jaringan. Coba lagi.', 'danger'));
                    });
                })();
            </script>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->include('partials/footer') ?>