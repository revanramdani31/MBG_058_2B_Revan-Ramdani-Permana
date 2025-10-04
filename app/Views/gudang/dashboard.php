<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gudang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="container mt-4">

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <h1 class="mb-3">Selamat Datang di Dashboard Gudang</h1>
    <p>Anda berhasil login sebagai <strong>role Gudang</strong>.</p>
    <p>User: <span class="text-primary"><?= session()->get('user_name') ?></span></p>

    <a href="/logout" class="btn btn-danger">Logout</a>

</body>

</html>