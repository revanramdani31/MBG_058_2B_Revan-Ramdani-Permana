<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login') ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" crossorigin="anonymous">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= site_url('/') ?>">Aplikasi Pemantauan Bahan Baku MBG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('user')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('logout') ?>">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link active" href="<?= site_url('login') ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card shadow-sm w-100 mx-auto" style="max-width: 400px;">
                <div class="card-body p-4">
                    <h3 class="text-center mb-3">Login</h3>
                    <p class="text-center text-muted small mb-4">Masukkan email dan password Anda</p>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small text-center">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="Masukkan Email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Masukkan Password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-muted py-3 mt-auto border-top">
        <div class="container">
            <small>© <?= date('Y') ?> Tugas UTS.</small><br>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            crossorigin="anonymous"></script>
</body>
</html>
