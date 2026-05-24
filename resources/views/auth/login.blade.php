{{--
    FILE: resources/views/auth/login.blade.php
    Modern clean login page with Show/Hide Password
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — Personal Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#F4F6FB;min-height:100vh;display:flex;align-items:center;justify-content:center}
.container{width:100%;max-width:420px;padding:20px}
.card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.08)}
.card-top{background:linear-gradient(135deg,#1D9E75,#0F6E56);padding:32px 36px;text-align:center;color:#fff}
.card-top .icon{width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px}
.card-top h2{font-size:20px;font-weight:700;margin-bottom:4px}
.card-top p{font-size:13px;opacity:0.8}
.card-body{padding:32px 36px}
.form-group{margin-bottom:20px}
label{display:block;font-size:12.5px;font-weight:600;color:#6B7280;margin-bottom:6px}
.input-wrap{position:relative}
.input-wrap .prefix-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:15px}
/* Tambahan styling untuk tombol mata di kanan */
.toggle-password{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:15px;cursor:pointer;background:none;border:none;outline:none;padding:5px;}
.toggle-password:hover{color:#1D9E75}
input[type=email],input[type=password],input[type=text]{width:100%;padding:11px 40px 11px 40px;font-family:inherit;font-size:13.5px;border:1.5px solid #E5E7EB;border-radius:10px;color:#1A1D2E;outline:none;transition:border-color 0.2s}
input:focus{border-color:#1D9E75;box-shadow:0 0 0 3px rgba(29,158,117,0.1)}
.remember{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.remember label{font-size:12.5px;margin:0;display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:500;color:#1A1D2E}
.remember a{font-size:12.5px;color:#1D9E75;font-weight:600;text-decoration:none}
.btn-submit{width:100%;padding:12px;background:#1D9E75;color:#fff;border:none;border-radius:10px;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 14px rgba(29,158,117,0.3)}
.btn-submit:hover{background:#0F6E56;transform:translateY(-1px);box-shadow:0 6px 18px rgba(29,158,117,0.4)}
.divider{text-align:center;margin:20px 0;font-size:12.5px;color:#9CA3AF}
.register-link{text-align:center;font-size:13px;color:#6B7280}
.register-link a{color:#1D9E75;font-weight:700;text-decoration:none}
.alert-error{background:#FEF2F2;border:1px solid #FCA5A5;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#991B1B}
.is-invalid{border-color:#EF4444 !important}
.invalid-feedback{color:#EF4444;font-size:12px;margin-top:4px;display:block}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-top">
            <div class="icon">🌐<i class="fas fa-user-circle"></i></div>
            <h2>Personal Manager</h2>
            <p>Masuk untuk melanjutkan</p>
        </div>
        <div class="card-body">

            @if(session('status'))
                <div class="alert-error" style="background:#ECFDF5;border-color:#6EE7B7;color:#065F46;">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Alamat Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope prefix-icon"></i>
                        <input type="email" name="email"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required autofocus autocomplete="email">
                    </div>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock prefix-icon"></i>
                        <input type="password" name="password" id="password"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Masukkan password"
                               required autocomplete="current-password">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
                    </div>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="remember">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <div class="divider">atau</div>
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, iconElement) {
    const passwordInput = document.getElementById(inputId);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        iconElement.classList.remove('fa-eye');
        iconElement.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        iconElement.classList.remove('fa-eye-slash');
        iconElement.classList.add('fa-eye');
    }
}
</script>
</body>
</html>