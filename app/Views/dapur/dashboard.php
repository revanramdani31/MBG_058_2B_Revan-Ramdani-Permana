<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dapur</title>
</head>
<body>
    <h1>Selamat Datang di Dashboard Dapur</h1>
    <p>Anda berhasil login sebagai role dapur.</p>
    <p>User: <?= session()->get('user_name') ?></p>
    
    <a href="/logout">Logout</a>
</body>
</html>