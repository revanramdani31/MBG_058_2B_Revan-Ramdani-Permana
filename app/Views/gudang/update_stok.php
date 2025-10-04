<?= $this->include('partials/header', ['title' => 'Update Stok']) ?>

<div class="container mt-4">
    <h3>Update Stok Bahan Baku</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($item)): ?>
        <div class="alert alert-warning">Data bahan tidak ditemukan.</div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= esc($item['nama']) ?> <small class="text-muted">(<?= esc($item['kategori']) ?>)</small></h5>
                <p>Stok saat ini: <strong id="current-stock"><?= esc($item['jumlah']) ?></strong> <?= esc($item['satuan']) ?></p>

                <form id="updateStockForm" method="post" action="<?= site_url('gudang/bahan/'.$item['id'].'/update-stock') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="operasi" class="form-label">Tambah atau Kurangi</label>
                        <select id="operasi" name="operasi" class="form-select">
                            <option value="tambah">Tambah</option>
                            <option value="kurang">Kurangi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" min="0" value="0" required>
                        <div class="form-text">Masukkan angka, sistem menolak jika stok akhir &lt; 0.</div>
                    </div>

                    <div class="mb-3">
                        <p>Stok akhir akan menjadi: <strong id="result-stock">-</strong></p>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Update Stok</button>
                        <a href="<?= site_url('/gudang/dashboard') ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    (function(){
        const currentStockEl = document.getElementById('current-stock');
        const operasiEl = document.getElementById('operasi');
        const jumlahEl = document.getElementById('jumlah');
        const resultEl = document.getElementById('result-stock');
        const form = document.getElementById('updateStockForm');
        const submitBtn = document.getElementById('submitBtn');

        function compute() {
            const current = parseInt(currentStockEl.textContent, 10) || 0;
            const jumlah = parseInt(jumlahEl.value, 10) || 0;
            const op = operasiEl.value;
            let result = current;

            if (op === 'tambah') result = current + jumlah;
            else result = current - jumlah;

            resultEl.textContent = result;

            if (result < 0 || jumlah < 0) {
                submitBtn.disabled = true;
                resultEl.style.color = 'red';
            } else {
                submitBtn.disabled = false;
                resultEl.style.color = '';
            }
        }

        operasiEl.addEventListener('change', compute);
        jumlahEl.addEventListener('input', compute);

        compute();

        form.addEventListener('submit', function(e){
            const result = parseInt(resultEl.textContent, 10) || 0;
            if (result < 0) {
                e.preventDefault();
                alert('Stok akhir tidak boleh kurang dari 0. Periksa kembali input Anda.');
            }
        });
    })();
</script>

<?= $this->include('partials/footer') ?>
