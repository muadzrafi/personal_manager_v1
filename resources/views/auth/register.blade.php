<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun — Personal Manager</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
    </style>
</head>
<body class="hold-transition">
 
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="col-md-5 col-lg-4">
 
    <div class="card shadow-lg">
        <div class="card-header text-center bg-success text-white py-4">
            <h4 class="mb-1">
                <i class="fas fa-user-plus mr-2"></i>Buat Akun Baru
            </h4>
            <p class="mb-0 small">Personal Manager — Gratis selamanya</p>
        </div>
 
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
 
                {{-- Nama --}}
                <div class="input-group mb-3">
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama Lengkap"
                           value="{{ old('name') }}"
                           required autofocus autocomplete="name">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                    @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>
 
                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Alamat Email"
                           value="{{ old('email') }}"
                           required autocomplete="email">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                    </div>
                    @error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>
 
                {{-- Password --}}
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password (min. 8 karakter)"
                           required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                    @error('password') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>
 
                {{-- Konfirmasi Password --}}
                <div class="input-group mb-4">
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi Password"
                           required autocomplete="new-password">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                </div>
 
                <button type="submit" class="btn btn-success btn-block btn-lg">
                    <i class="fas fa-user-plus mr-1"></i> Daftar Sekarang
                </button>
            </form>
 
            <div class="mt-3 text-center">
                <p class="mb-0 text-muted small">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary font-weight-bold">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
 
</div>
</div>
 
<script src="{{ asset('vendor/adminlte/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>