{{--
    FILE: resources/views/auth/register.blade.php
    Modern clean register page with Show/Hide Password
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar — Personal Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#F4F6FB;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.container{width:100%;max-width:440px}
.card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.08)}
.card-top{background:linear-gradient(135deg,#10B981,#059669);padding:28px 36px;text-align:center;color:#fff}
.card-top .icon{width:52px;height:52px;background:rgba(255,255,255,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:22px}
.card-top h2{font-size:19px;font-weight:700;margin-bottom:3px}
.card-top p{font-size:12.5px;opacity:0.8}
.card-body{padding:28px 36px}
.form-group{margin-bottom:18px}
label{display:block;font-size:12.5px;font-weight:600;color:#6B7280;margin-bottom:5px}
.input-wrap{position:relative}
.input-wrap .prefix-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:14px}
/* Tombol mata kanan */
.toggle-password{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:14px;cursor:pointer;background:none;border:none;outline:none;padding:5px;}
.toggle-password:hover{color:#10B981}
input{width:100%;padding:10px 40px 10px 40px;font-family:inherit;font-size:13.5px;border:1.5px solid #E5E7EB;border-radius:10px;color:#1A1D2E;outline:none;transition:border-color 0.2s}
input:focus{border-color:#10B981;box-shadow:0 0 0 3px rgba(16,185,129,0.1)}
.is-invalid{border-color:#EF4444 !important}
.invalid-feedback{color:#EF4444;font-size:12px;margin-top:4px;display:block}
.btn-submit{width:100%;padding:12px;background:#10B981;color:#fff;border:none;border-radius:10px;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 14px rgba(16,185,129,0.3);margin-top:4px}
.btn-submit:hover{background:#059669;transform:translateY(-1px)}
.login-link{text-align:center;font-size:13px;color:#6B7280;margin-top:18px}
.login-link a{color:#1D9E75;font-weight:700;text-decoration:none}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-top">
            <div class="icon">🌐<i class="fas fa-user-plus"></i></div>
            <h2>Buat Akun Baru</h2>
            <p>Personal Manager — Gratis selamanya</p>
        </div>
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="fas fa-user prefix-icon"></i>
                        <input type="text" name="name"
                               class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') }}"
                               placeholder="Nama Anda"
                               required autofocus autocomplete="name">
                    </div>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Alamat Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope prefix-icon"></i>
                        <input type="email" name="email"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required autocomplete="email">
                    </div>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock prefix-icon"></i>
                        <input type="password" name="password" id="password"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Minimal 8 karakter"
                               required autocomplete="new-password">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
                    </div>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock prefix-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               placeholder="Ulangi password"
                               required autocomplete="new-password">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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