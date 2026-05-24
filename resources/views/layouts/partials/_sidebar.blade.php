{{-- FILE: resources/views/layouts/partials/_sidebar.blade.php --}}
<aside class="main-sidebar sidebar-light-primary elevation-0">

    {{-- Brand --}}
    <a href="{{ route('user.dashboard') }}" class="brand-link">
        <div style="width:34px;height:34px;background:#1D9E75;border-radius:10px;
                    display:inline-flex;align-items:center;justify-content:center;
                    margin-right:10px;vertical-align:middle;">🌐
            <i class="fas fa-user-circle" style="color:#fff;font-size:17px;"></i>
        </div>
        <span class="brand-text"
              style="font-size:15px;font-weight:700;color:#1A1D2E !important;vertical-align:middle;">
            Personal Manager
        </span>
    </a>

    <div class="sidebar">

        {{-- User Panel --}}
        <div class="user-panel mt-2 pb-3 mb-2 d-flex">
            <div class="image" style="padding-top:0; display:flex; align-items:center;">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                         class="img-circle elevation-0"
                         alt="Avatar"
                         style="width:36px;height:36px;object-fit:cover;">
                @else
                    <div style="width:36px;height:36px;border-radius:50%;background:#1D9E75;
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-size:14px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="info" style="padding-left:10px;">
                <a href="{{ route('user.profile.index') }}"
                   style="color:#1A1D2E !important;font-size:13px;font-weight:600;display:block;">
                    {{ auth()->user()->name }}
                </a>
                <span style="font-size:11px;color:#9CA3AF;">Regular User</span>
            </div>
        </div>

        <nav class="mt-1" style="padding:0 8px;">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}"
                       class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.dashboard') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Pencarian --}}
                <li class="nav-item">
                    <a href="{{ route('user.search') }}"
                       class="nav-link {{ request()->routeIs('user.search') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.search') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-search"></i>
                        <p>Pencarian</p>
                    </a>
                </li>

                <li class="nav-header">PRODUKTIVITAS</li>

                {{-- Tugas --}}
                <li class="nav-item {{ request()->routeIs('user.tasks.*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->routeIs('user.tasks.*') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.tasks.*') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tugas <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.index') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.index') ? 'active' : '' }}"
                               style="{{ request()->routeIs('user.tasks.index') ? '' : 'color:#6B7280 !important;' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Tugas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.create') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.create') ? 'active' : '' }}"
                               style="{{ request()->routeIs('user.tasks.create') ? '' : 'color:#6B7280 !important;' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tugas Baru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.tasks.calendar') }}"
                               class="nav-link {{ request()->routeIs('user.tasks.calendar') ? 'active' : '' }}"
                               style="{{ request()->routeIs('user.tasks.calendar') ? '' : 'color:#6B7280 !important;' }}">
                                <i class="far fa-calendar nav-icon"></i>
                                <p>Kalender</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">KEUANGAN</li>

                {{-- Keuangan --}}
                <li class="nav-item">
                    <a href="{{ route('user.financial.index') }}"
                       class="nav-link {{ request()->routeIs('user.financial.*') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.financial.*') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Laporan Keuangan</p>
                    </a>
                </li>

                <li class="nav-header">JURNAL</li>

                {{-- Jurnal --}}
                <li class="nav-item {{ request()->routeIs('user.journals.*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->routeIs('user.journals.*') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.journals.*') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Jurnal Harian <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.journals.index') }}"
                               class="nav-link {{ request()->routeIs('user.journals.index') ? 'active' : '' }}"
                               style="{{ request()->routeIs('user.journals.index') ? '' : 'color:#6B7280 !important;' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Semua Jurnal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.journals.create') }}"
                               class="nav-link {{ request()->routeIs('user.journals.create') ? 'active' : '' }}"
                               style="{{ request()->routeIs('user.journals.create') ? '' : 'color:#6B7280 !important;' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tulis Baru</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">AKUN</li>

                {{-- Profil --}}
                <li class="nav-item">
                    <a href="{{ route('user.profile.index') }}"
                       class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}"
                       style="{{ request()->routeIs('user.profile.*') ? '' : 'color:#6B7280 !important;' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Profil & Pengaturan</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>