@extends('layouts.master')
 
@section('title', 'Profil & Pengaturan')
@section('page-title', 'Profil & Pengaturan')
 
@section('breadcrumbs')
    <li class="breadcrumb-item active">Profil</li>
@endsection
 
@section('content')
<div class="row">
 
    {{-- ─── Kolom Kiri: Info Profil ─────────────────────────── --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body text-center pt-4">
                {{-- Avatar --}}
                <div class="mb-3 position-relative d-inline-block">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}"
                             alt="Avatar"
                             class="img-circle elevation-2"
                             style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-primary text-white"
                             style="width:100px;height:100px;font-size:2.5rem;margin:0 auto;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
 
                <h5 class="mb-0 font-weight-bold">{{ $user->name }}</h5>
                <p class="text-muted small mb-1">{{ $user->email }}</p>
                <span class="badge badge-{{ $user->is_admin ? 'danger' : 'primary' }}">
                    {{ $user->is_admin ? 'Administrator' : 'User' }}
                </span>
 
                <hr>
 
                <div class="text-left small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Bergabung</span>
                        <strong>{{ $user->created_at->format('d M Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Tugas</span>
                        <strong>{{ $user->tasks()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Jurnal</span>
                        <strong>{{ $user->journals()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Transaksi</span>
                        <strong>{{ $user->financialRecords()->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    {{-- ─── Kolom Kanan: Form Settings ─────────────────────── --}}
    <div class="col-md-8">
 
        {{-- Tab Navigation --}}
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs" id="profileTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-info">
                            <i class="fas fa-user mr-1"></i> Info Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-password">
                            <i class="fas fa-lock mr-1"></i> Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-avatar">
                            <i class="fas fa-camera mr-1"></i> Foto Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-toggle="tab" href="#tab-delete">
                            <i class="fas fa-trash mr-1"></i> Hapus Akun
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
 
                    {{-- ─── Tab 1: Info Akun ─────────────────────── --}}
                    <div class="tab-pane fade show active" id="tab-info">
                        @if(session('success_info'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_info') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-info') }}" method="POST">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
 
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 2: Password ──────────────────────── --}}
                    <div class="tab-pane fade" id="tab-password">
                        @if(session('success_password'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_password') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-password') }}" method="POST">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       placeholder="Masukkan password saat ini" required>
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi password baru" required>
                            </div>
 
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key mr-1"></i> Ganti Password
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 3: Foto Profil ───────────────────── --}}
                    <div class="tab-pane fade" id="tab-avatar">
                        @if(session('success_avatar'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_avatar') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-avatar') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Pilih Foto Baru</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="avatar" id="avatarInput"
                                               class="custom-file-input @error('avatar') is-invalid @enderror"
                                               accept="image/jpg,image/jpeg,image/png,image/webp">
                                        <label class="custom-file-label" for="avatarInput">
                                            Pilih file...
                                        </label>
                                    </div>
                                </div>
                                @error('avatar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                            </div>
 
                            {{-- Preview sebelum upload --}}
                            <div id="avatarPreview" class="mb-3" style="display:none">
                                <img id="previewImg" src="" alt="Preview"
                                     class="img-circle"
                                     style="width:80px;height:80px;object-fit:cover;">
                                <span class="ml-2 small text-muted">Preview</span>
                            </div>
 
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-upload mr-1"></i> Upload Foto
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 4: Hapus Akun ────────────────────── --}}
                    <div class="tab-pane fade" id="tab-delete">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Peringatan!</strong> Tindakan ini <strong>tidak bisa dibatalkan</strong>.
                            Semua data Anda (tugas, keuangan, jurnal) akan dihapus permanen.
                        </div>
 
                        <form action="{{ route('user.profile.destroy') }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus akun? SEMUA data akan hilang permanen!')">
                            @csrf @method('DELETE')
 
                            <div class="form-group">
                                <label>Konfirmasi dengan Password Anda <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password untuk konfirmasi" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash mr-1"></i> Hapus Akun Saya Permanen
                            </button>
                        </form>
                    </div>
 
                </div>
            </div>
        </div>
 
    </div>
</div>
@endsection
 
@push('scripts')
<script>
// Preview foto sebelum upload
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
 
    // Update label nama file
    document.querySelector('.custom-file-label').textContent = file.name;
 
    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('avatarPreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
 
// Buka tab yang sesuai jika ada session error/success
@if(session('success_password') || $errors->has('current_password') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[href="#tab-password"]').click();
    });
@endif
 
@if(session('success_avatar') || $errors->has('avatar'))
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[href="#tab-avatar"]').click();
    });
@endif
</script>
@endpush@extends('layouts.master')
 
@section('title', 'Profil & Pengaturan')
@section('page-title', 'Profil & Pengaturan')
 
@section('breadcrumbs')
    <li class="breadcrumb-item active">Profil</li>
@endsection
 
@section('content')
<div class="row">
 
    {{-- ─── Kolom Kiri: Info Profil ─────────────────────────── --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body text-center pt-4">
                {{-- Avatar --}}
                <div class="mb-3 position-relative d-inline-block">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}"
                             alt="Avatar"
                             class="img-circle elevation-2"
                             style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-primary text-white"
                             style="width:100px;height:100px;font-size:2.5rem;margin:0 auto;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
 
                <h5 class="mb-0 font-weight-bold">{{ $user->name }}</h5>
                <p class="text-muted small mb-1">{{ $user->email }}</p>
                <span class="badge badge-{{ $user->is_admin ? 'danger' : 'primary' }}">
                    {{ $user->is_admin ? 'Administrator' : 'User' }}
                </span>
 
                <hr>
 
                <div class="text-left small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Bergabung</span>
                        <strong>{{ $user->created_at->format('d M Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Tugas</span>
                        <strong>{{ $user->tasks()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Jurnal</span>
                        <strong>{{ $user->journals()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Transaksi</span>
                        <strong>{{ $user->financialRecords()->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    {{-- ─── Kolom Kanan: Form Settings ─────────────────────── --}}
    <div class="col-md-8">
 
        {{-- Tab Navigation --}}
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs" id="profileTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-info">
                            <i class="fas fa-user mr-1"></i> Info Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-password">
                            <i class="fas fa-lock mr-1"></i> Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-avatar">
                            <i class="fas fa-camera mr-1"></i> Foto Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-toggle="tab" href="#tab-delete">
                            <i class="fas fa-trash mr-1"></i> Hapus Akun
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
 
                    {{-- ─── Tab 1: Info Akun ─────────────────────── --}}
                    <div class="tab-pane fade show active" id="tab-info">
                        @if(session('success_info'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_info') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-info') }}" method="POST">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
 
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 2: Password ──────────────────────── --}}
                    <div class="tab-pane fade" id="tab-password">
                        @if(session('success_password'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_password') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-password') }}" method="POST">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       placeholder="Masukkan password saat ini" required>
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <div class="form-group">
                                <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi password baru" required>
                            </div>
 
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key mr-1"></i> Ganti Password
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 3: Foto Profil ───────────────────── --}}
                    <div class="tab-pane fade" id="tab-avatar">
                        @if(session('success_avatar'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> {{ session('success_avatar') }}
                            </div>
                        @endif
 
                        <form action="{{ route('user.profile.update-avatar') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf @method('PUT')
 
                            <div class="form-group">
                                <label>Pilih Foto Baru</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="avatar" id="avatarInput"
                                               class="custom-file-input @error('avatar') is-invalid @enderror"
                                               accept="image/jpg,image/jpeg,image/png,image/webp">
                                        <label class="custom-file-label" for="avatarInput">
                                            Pilih file...
                                        </label>
                                    </div>
                                </div>
                                @error('avatar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                            </div>
 
                            {{-- Preview sebelum upload --}}
                            <div id="avatarPreview" class="mb-3" style="display:none">
                                <img id="previewImg" src="" alt="Preview"
                                     class="img-circle"
                                     style="width:80px;height:80px;object-fit:cover;">
                                <span class="ml-2 small text-muted">Preview</span>
                            </div>
 
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-upload mr-1"></i> Upload Foto
                            </button>
                        </form>
                    </div>
 
                    {{-- ─── Tab 4: Hapus Akun ────────────────────── --}}
                    <div class="tab-pane fade" id="tab-delete">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Peringatan!</strong> Tindakan ini <strong>tidak bisa dibatalkan</strong>.
                            Semua data Anda (tugas, keuangan, jurnal) akan dihapus permanen.
                        </div>
 
                        <form action="{{ route('user.profile.destroy') }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus akun? SEMUA data akan hilang permanen!')">
                            @csrf @method('DELETE')
 
                            <div class="form-group">
                                <label>Konfirmasi dengan Password Anda <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password untuk konfirmasi" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
 
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash mr-1"></i> Hapus Akun Saya Permanen
                            </button>
                        </form>
                    </div>
 
                </div>
            </div>
        </div>
 
    </div>
</div>
@endsection
 
@push('scripts')
<script>
// Preview foto sebelum upload
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
 
    // Update label nama file
    document.querySelector('.custom-file-label').textContent = file.name;
 
    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('avatarPreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
 
// Buka tab yang sesuai jika ada session error/success
@if(session('success_password') || $errors->has('current_password') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[href="#tab-password"]').click();
    });
@endif
 
@if(session('success_avatar') || $errors->has('avatar'))
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[href="#tab-avatar"]').click();
    });
@endif
</script>
@endpush