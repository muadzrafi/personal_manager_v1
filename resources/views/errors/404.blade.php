<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition">
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh; background:#f4f6f9">
    <div class="text-center">
        <h1 style="font-size:8rem; font-weight:900; color:#6c757d; line-height:1">404</h1>
        <h3 class="mb-2">Halaman Tidak Ditemukan</h3>
        <p class="text-muted mb-4">
            Halaman yang Anda cari tidak ada atau telah dipindahkan.
        </p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home mr-1"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
</body>
</html>