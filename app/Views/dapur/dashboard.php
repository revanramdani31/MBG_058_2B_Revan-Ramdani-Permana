<?= $this->include('partials/header', ['title' => 'Dashboard Gudang']) ?>

<div class="container mt-4">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4">Selamat Datang, <?= esc(session()->get('user_name')) ?></h1>
            <div class="text-muted">Role: <?= esc(session()->get('user_role')) ?></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Dashboard Dapur</h3>
        <div>
            <a href="/dapur/permintaan/create" class="btn btn-sm btn-primary">Buat Permintaan Bahan</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p>Anda berhasil login sebagai <strong><?= esc(session()->get('user_role')) ?></strong>.</p>
            <p>Gunakan tombol di atas untuk membuat permintaan bahan baru atau keluar dari akun Anda.</p>
        </div>
    </div>

</div>


<?= $this->include('partials/footer') ?>