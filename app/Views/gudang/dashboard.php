<?= $this->include('partials/header', ['title' => 'Dashboard Gudang']) ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4">Selamat Datang, <?= esc(session()->get('user_name')) ?></h1>
                <div class="text-muted">Role: <?= esc(session()->get('user_role')) ?></div>
            </div>
        
        </div>
        <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Bahan Baku</h3>
            <div>
                <a href="/gudang/bahan/create" class="btn btn-sm btn-primary">Tambah Bahan Baku</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Kadaluarsa</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr><td colspan="8" class="text-center py-4">Belum ada data bahan baku.</td></tr>
                            <?php else: ?>
                                <?php $i = 1; foreach ($items as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($row['nama']) ?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                        <td><?= esc($row['jumlah']) ?></td>
                                        <td><?= esc($row['satuan']) ?></td>
                                        <td><?= esc($row['tanggal_masuk']) ?></td>
                                        <td><?= esc($row['tanggal_kadaluarsa']) ?></td>
                                        <td>
                                            <?php $s = $row['computed_status'] ?? ($row['status'] ?? 'Tersedia'); ?>
                                            <?php if ($s === 'Kadaluarsa'): ?>
                                                <span class="badge bg-danger"><?= esc($s) ?></span>
                                            <?php elseif ($s === 'Segera Kadaluarsa'): ?>
                                                <span class="badge bg-warning text-dark"><?= esc($s) ?></span>
                                            <?php elseif ($s === 'Habis'): ?>
                                                <span class="badge bg-secondary"><?= esc($s) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?= esc($s) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td> delete update</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
    </div>

<?= $this->include('partials/footer') ?>