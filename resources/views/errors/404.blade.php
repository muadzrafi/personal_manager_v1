.icon-wrap{width:72px;height:72px;background:#E1F5EE;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;color:#1D9E75;}
h2{font-size:22px;font-weight:700;color:#1A1D2E;margin-bottom:8px;}
p{font-size:14px;color:#6B7280;max-width:360px;margin:0 auto 28px;}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:10px;font-size:13.5px;font-weight:600;text-decoration:none;transition:all 0.2s;}
.btn-primary{background:#1D9E75;color:#fff;box-shadow:0 4px 12px rgba(29,158,117,0.28);}
.btn-primary:hover{background:#0F6E56;transform:translateY(-1px);}
</style>
</head>
<body>
<div class="wrap">
    <div class="icon-wrap"><i class="fas fa-map-signs"></i></div>
    <div class="code">4<span>0</span>4</div>
    <h2>Halaman Tidak Ditemukan</h2>
    <p>Halaman yang Anda cari tidak ada atau telah dipindahkan. Coba kembali ke dashboard.</p>
    <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
        <i class="fas fa-home"></i> Kembali ke Dashboard
    </a>
</div>
</body>
</html>