<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition">
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh; background:#f4f6f9">
    <div class="text-center">
        <h1 style="font-size:8rem; font-weight:900; color:#dc3545; line-height:1">403</h1>
        <h3 class="mb-2">Akses Ditolak</h3>
        <p class="text-muted mb-4">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            {{ $exception->getMessage() ?: 'Silakan kembali ke halaman yang sesuai.' }}
        </p>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('user.dashboard') }}"
           class="btn btn-danger mr-2">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-default">
            <i class="fas fa-home mr-1"></i> Dashboard
        </a>
    </div>
</div>
</body>
</html>