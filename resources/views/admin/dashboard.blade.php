{{--
    FILE: resources/views/admin/dashboard.blade.php
    HANYA untuk admin panel. File ini TERPISAH dari dashboard user.
--}}
@extends('layouts.admin.master')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Global')

@section('content')

{{-- Banner privasi --}}
<div class="alert alert-warning">
    <i class="fas fa-shield-alt mr-2"></i>
    <strong>Mode Privasi Aktif.</strong>
    Anda hanya melihat statistik agregat sistem. Data detail pengguna tidak ditampilkan.
</div>

{{-- ─── Kartu Statistik Global ─────────────────────────────── --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $globalStats['total_users'] }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <span class="small-box-footer">User terdaftar</span>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $globalStats['total_tasks'] }}</h3>
                <p>Total Tugas (Sistem)</p>
            </div>
            <div class="icon"><i class="fas fa-tasks"></i></div>
            <span class="small-box-footer">Seluruh pengguna</span>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $globalStats['avg_tasks_per_user'] }}</h3>
                <p>Rata-rata Tugas/User</p>
            </div>
            <div class="icon"><i class="fas fa-chart-bar"></i></div>
            <span class="small-box-footer">Rata-rata produktivitas</span>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $globalStats['new_users_this_month'] }}</h3>
                <p>User Baru Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <span class="small-box-footer">{{ now()->format('F Y') }}</span>
        </div>
    </div>
</div>

{{-- ─── Chart Row ───────────────────────────────────────────── --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus mr-1"></i> Pertumbuhan User (6 Bulan Terakhir)
                </h3>
            </div>
            <div class="card-body">
                <canvas id="userGrowthChart" style="height:250px; min-height:250px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i> Distribusi Status Tugas
                </h3>
            </div>
            <div class="card-body">
                <canvas id="taskStatusChart" style="height:250px; min-height:250px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ─── Volume Transaksi ────────────────────────────────────── --}}
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-lock mr-2"></i> Volume Total Transaksi Sistem
                </h3>
            </div>
            <div class="card-body">
                <h2 class="text-primary">
                    Rp {{ number_format($globalStats['total_transaction_volume'], 0, ',', '.') }}
                </h2>
                <p class="text-muted mb-0">
                    Total volume transaksi seluruh pengguna tanpa breakdown per individu.
                    Detail keuangan individual tidak dapat diakses dari panel ini.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ─── User Growth Bar Chart ────────────────────────────────────
new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! $growthLabels !!},
        datasets: [{
            label: 'User Baru',
            data: {!! $growthData !!},
            backgroundColor: 'rgba(0,123,255,0.7)',
            borderColor: 'rgba(0,123,255,1)',
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// ─── Task Status Donut Chart ──────────────────────────────────
const taskStatusData = {!! $taskStatusDist !!};
new Chart(document.getElementById('taskStatusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(taskStatusData).map(s => s.replace('_', ' ').toUpperCase()),
        datasets: [{
            data: Object.values(taskStatusData),
            backgroundColor: ['#ffc107', '#007bff', '#28a745', '#6c757d'],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush