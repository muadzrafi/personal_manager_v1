{{-- FILE: resources/views/layouts/partials/_navbar.blade.php --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                👁️‍🗨️<i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    {{-- Search bar --}}
    <ul class="navbar-nav ml-2 d-none d-sm-flex">
        <li class="nav-item">
            <form method="GET" action="{{ route('user.search') }}" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" name="q"
                           class="form-control"
                           placeholder="Cari tugas, jurnal, keuangan..."
                           value="{{ request('q') }}"
                           style="width:240px; border-radius:10px 0 0 10px !important;">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"
                                style="border-radius:0 10px 10px 0 !important; border-left:none;">
                            <i class="fas fa-search" style="color:#9CA3AF"></i>
                        </button>
                    </div>
                </div>
            </form>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item mr-2">
            <a class="nav-link p-1" href="#" data-widget="fullscreen" role="button">
                <i class="fas fa-expand-arrows-alt" style="color:#9CA3AF"></i>
            </a>
        </li>

        {{-- User dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#"
               style="gap:8px; padding:6px 10px;">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         alt="Avatar"
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                @else
                    <div style="width:32px;height:32px;border-radius:50%;background:#1D9E75;
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <span class="d-none d-md-inline"
                      style="font-size:13.5px;font-weight:600;color:#1A1D2E;">
                    {{ auth()->user()->name }}
                </span>
                <i class="fas fa-chevron-down" style="font-size:10px;color:#9CA3AF"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('user.profile.index') }}" class="dropdown-item">
                    <i class="fas fa-user-cog fa-fw mr-2"></i> Profil & Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt fa-fw mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>