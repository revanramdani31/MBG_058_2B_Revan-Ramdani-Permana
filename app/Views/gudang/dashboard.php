<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Sistem Manajemen Bahan Baku - Gudang</h2>
    </div>
    <div>
    Halo, <?= session()->get('user_name') ?> (<?= ucfirst(session()->get('user_role')) ?>)
    <a href="/logout">Logout</a>
    </div>

        <table>
        <thead>
            <tr>
                <th>Nama Bahan</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($bahan_baku)): ?>
                <?php foreach($bahan_baku as $bahan): ?>
                <tr>
                    <td>
                        <strong><?= esc($bahan['nama']) ?></strong>
                    </td>
                    <td><?= esc($bahan['kategori']) ?></td>
                    <td>
                        <span class="<?= $bahan['jumlah'] <= 0 ? 'text-danger' : ($bahan['jumlah'] <= 10 ? 'text-warning' : 'text-success') ?>">
                            <?= esc($bahan['jumlah']) ?>
                        </span>
                    </td>
                    <td><?= esc($bahan['satuan']) ?></td>
                    <td><?= date('d/m/Y', strtotime($bahan['tanggal_masuk'])) ?></td>
                    <td>
                        <?php 
                        $tgl_kadaluarsa = strtotime($bahan['tanggal_kadaluarsa']);
                        $hari_ini = time();
                        $selisih_hari = floor(($tgl_kadaluarsa - $hari_ini) / (60 * 60 * 24));
                        ?>
                        <span>
                            <?= date('d/m/Y', $tgl_kadaluarsa) ?>
                            <?php if ($selisih_hari <= 7 && $selisih_hari > 0): ?>
                                <small>(<?= $selisih_hari ?> hari lagi)</small>
                            <?php elseif ($selisih_hari <= 0): ?>
                                <small>(Kadaluarsa)</small>
                            <?php endif; ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $bahan['status'] ?>">
                            <?php 
                            switch($bahan['status']) {
                                case 'tersedia': echo 'Tersedia'; break;
                                case 'segera_kadaluarsa': echo 'Segera Kadaluarsa'; break;
                                case 'kadaluarsa': echo 'Kadaluarsa'; break;
                                case 'habis': echo 'Habis'; break;
                                default: echo ucfirst($bahan['status']);
                            }
                            ?>
                        </span>
                    </td>
                    <td>
                        <div>
                            <a >
                                Detail
                            </a>
                            <a>
                                Edit
                            </a>
                            <a>
                                Update Stok
                            </a>
                            <a >
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>
                        <div >
                            <h5>Belum Ada Data Bahan Baku</h5>
                            <p class="text-muted">Silakan tambah bahan baku terlebih dahulu</p>
                            <a href="<?= base_url('/bahan-baku/tambah') ?>" class="btn btn-success">
                                Tambah Bahan Baku Pertama
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>