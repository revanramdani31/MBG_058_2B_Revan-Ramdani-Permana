<?= $this->include('partials/header', ['title' => 'Dashboard Gudang']) ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4">Selamat Datang, <?= esc(session()->get('user_name')) ?></h1>
                <div class="text-muted">Role: <?= esc(session()->get('user_role')) ?></div>
            </div>
            <div>
                <a href="/gudang/bahan/create" class="btn btn-primary me-2">Tambah Bahan Baku</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
    </div>

<?= $this->include('partials/footer') ?>