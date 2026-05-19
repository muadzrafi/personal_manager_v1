<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Personal Manager</title>
 
    {{-- AdminLTE CSS via package jeroennoten --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .login-card-body { border-radius: 0 0 .5rem .5rem; }
        .card-header-logo { border-radius: .5rem .5rem 0 0; }
    </style>
</head>
<body class="hold-transition">
 
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="col-md-4 col-lg-3">
 
    <div class="card shadow-lg">
        {{-- Logo Header --}}
        <div class="card-header text-center bg-primary text-white card-header-logo py-4">
            <h4 class="mb-1">
                <i class="fas fa-user-cog mr-2"></i>Personal Manager
            </h4>
            <p class="mb-0 small opacity-75">Kelola waktu, keuangan, dan jurnal Anda</p>
        </div>
 
        <div class="login-card-body card-body">
            <p class="login-box-msg text-muted">Masuk untuk melanjutkan</p>
 
            {{-- Session Error --}}
            @if(session('status'))
                <div class="alert alert-success alert-sm">{{ session('status') }}</div>
            @endif
 
            <form action="{{ route('login') }}" method="POST">
                @csrf
 
                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Alamat Email"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="email">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
 
                {{-- Password --}}
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
 
                {{-- Remember Me --}}
                <div class="row mb-3">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <div class="col-5 text-right">
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
                        @endif
                    </div>
                </div>
 
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                </button>
            </form>
 
            <div class="mt-3 text-center">
                <p class="mb-0 text-muted small">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary font-weight-bold">Daftar sekarang</a>
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