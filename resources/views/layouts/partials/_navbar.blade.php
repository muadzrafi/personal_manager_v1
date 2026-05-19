<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
 
    {{-- Search Bar di Navbar --}}
    <ul class="navbar-nav ml-2">
        <li class="nav-item">
            <form method="GET" action="{{ route('user.search') }}" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control"
                           placeholder="Cari tugas, jurnal, keuangan..."
                           value="{{ request('q') }}"
                           style="width: 220px;">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </li>
    </ul>
 
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" data-widget="fullscreen" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
 
        {{-- User Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         alt="Avatar"
                         class="img-circle"
                         style="width:28px;height:28px;object-fit:cover;">
                @else
                    <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                          style="width:28px;height:28px;font-size:12px;font-weight:bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif
                <span class="d-none d-sm-inline ml-1">{{ auth()->user()->name }}</span>
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