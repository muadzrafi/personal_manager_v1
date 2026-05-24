{{-- errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>403 — Akses Ditolak</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#F4F6FB;min-height:100vh;display:flex;align-items:center;justify-content:center;}
.wrap{text-align:center;padding:40px 20px;}
.code{font-size:96px;font-weight:700;color:#E5E7EB;line-height:1;margin-bottom:8px;}
.code span{color:#EF4444;}
.icon-wrap{width:72px;height:72px;background:#FEF2F2;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;color:#EF4444;}
h2{font-size:22px;font-weight:700;color:#1A1D2E;margin-bottom:8px;}
p{font-size:14px;color:#6B7280;max-width:360px;margin:0 auto 28px;}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;transition:all 0.2s;}
.btn-primary{background:#1D9E75;color:#fff;box-shadow:0 4px 12px rgba(29,158,117,0.28);}
.btn-primary:hover{background:#0F6E56;transform:translateY(-1px);}
.btn-default{background:#F3F4F6;color:#1A1D2E;border:1px solid #E5E7EB;margin-left:8px;}
.btn-default:hover{background:#E5E7EB;}
</style>
</head>
<body>
<div class="wrap">
    <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>
    <div class="code">4<span>0</span>3</div>
    <h2>Akses Ditolak</h2>
    <p>Anda tidak memiliki izin untuk mengakses halaman ini. Silakan kembali ke halaman sebelumnya.</p>
    <div>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('user.dashboard') }}" class="btn btn-default">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </div>
</div>
</body>
</html>


{{-- errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>404 — Halaman Tidak Ditemukan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#F4F6FB;min-height:100vh;display:flex;align-items:center;justify-content:center;}