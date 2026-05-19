<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('user.dashboard') }}" class="brand-link">
        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}"
             alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-bold">Personal Manager</span>
    </a>
 
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         class="img-circle elevation-2"
                         alt="Avatar"
                         style="width:34px;height:34px;object-fit:cover;">
                @else
                    <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle elevation-2"
                          style="width:34px;height:34px;font-weight:bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif
            </div>
            <div class="info">
                <a href="{{ route('user.profile.index') }}" class="d-block text-truncate" style="max-width:140px">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>
 
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                role="menu" data-accordion="false">
 
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}"
                       class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
 
                <li class="nav-item">
                    <a href="{{ route('user.search') }}"
                       class="nav-link {{ request()->routeIs('user.search') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-search"></i>
                        <p>Pencarian</p>
                    </a>
                </li>
 
                <li class="nav-header">PRODUKTIVITAS</li>
 
                <li class="nav-item {{ request()->routeIs('user.tasks.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('user.tasks.index') }}" class="nav-link {{ request()->routeIs('user.tasks.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.index') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i><p>Daftar Tugas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.create') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i><p>Tugas Baru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.calendar') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.calendar') ? 'active' : '' }}">
                                <i class="far fa-calendar nav-icon"></i><p>Kalender</p>
                            </a>
                        </li>
                    </ul>
                </li>
 
                <li class="nav-header">KEUANGAN</li>
 
                <li class="nav-item">
                    <a href="{{ route('user.financial.index') }}"
                       class="nav-link {{ request()->routeIs('user.financial.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Laporan Keuangan</p>
                    </a>
                </li>
 
                <li class="nav-header">JURNAL</li>
 
                <li class="nav-item {{ request()->routeIs('user.journals.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('user.journals.index') }}" class="nav-link {{ request()->routeIs('user.journals.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Jurnal Harian <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.journals.index') }}"
                               class="nav-link {{ request()->routeIs('user.journals.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i><p>Semua Jurnal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.journals.create') }}"
                               class="nav-link {{ request()->routeIs('user.journals.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i><p>Tulis Baru</p>
                            </a>
                        </li>
                    </ul>
                </li>
 
                <li class="nav-header">AKUN</li>
 
                <li class="nav-item">
                    <a href="{{ route('user.profile.index') }}"
                       class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Profil & Pengaturan</p>
                    </a>
                </li>
 
            </ul>
        </nav>
    </div>
</aside>