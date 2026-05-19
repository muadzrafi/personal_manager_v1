{{--
    FILE: resources/views/dashboard/index.blade.php
    Dashboard user dengan 2 chart keuangan terpisah: Personal & Bisnis
--}}
@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Performa')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- ─── Baris 1: Kartu Statistik ───────────────────────────── --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_tasks'] }}</h3>
                <p>Total Tugas</p>
            </div>
            <div class="icon"><i class="fas fa-tasks"></i></div>
            <a href="{{ route('user.tasks.index') }}" class="small-box-footer">
                Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_tasks'] }}</h3>
                <p>Tugas Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="{{ route('user.tasks.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['completed_tasks'] }}</h3>
                <p>Tugas Selesai</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('user.tasks.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['total_journals'] }}</h3>
                <p>Total Jurnal</p>
            </div>
            <div class="icon"><i class="fas fa-book-open"></i></div>
            <a href="{{ route('user.journals.index') }}" class="small-box-footer">
                Lihat Jurnal <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

{{-- ─── Baris 2: Summary Keuangan Personal & Bisnis ──────────── --}}
<div class="row">

    {{-- Kartu Summary Personal --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-1"></i> Personal
                    <small class="text-muted ml-1">bulan ini</small>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('user.financial.index', ['tab' => 'personal']) }}"
                       class="btn btn-tool btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-arrow-up text-success mr-1"></i>Masuk</span>
                        <strong class="text-success small">Rp {{ number_format($personalIncome, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-arrow-down text-danger mr-1"></i>Keluar</span>
                        <strong class="text-danger small">Rp {{ number_format($personalExpense, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-balance-scale text-info mr-1"></i>Saldo</span>
                        <strong class="{{ $personalBalance >= 0 ? 'text-success' : 'text-danger' }} small">
                            Rp {{ number_format(abs($personalBalance), 0, ',', '.') }}
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Kartu Summary Bisnis --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-briefcase mr-1"></i> Bisnis
                    <small class="text-muted ml-1">bulan ini</small>
                </h3>
                <div class="card-tools">
                    <a href="{{ route('user.financial.index', ['tab' => 'business']) }}"
                       class="btn btn-tool btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-arrow-up text-success mr-1"></i>Masuk</span>
                        <strong class="text-success small">Rp {{ number_format($businessIncome, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-arrow-down text-danger mr-1"></i>Keluar</span>
                        <strong class="text-danger small">Rp {{ number_format($businessExpense, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-3 py-2">
                        <span class="text-muted small"><i class="fas fa-balance-scale text-info mr-1"></i>Saldo</span>
                        <strong class="{{ $businessBalance >= 0 ? 'text-success' : 'text-danger' }} small">
                            Rp {{ number_format(abs($businessBalance), 0, ',', '.') }}
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Chart Personal --}}
    <div class="col-lg-6 col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1 text-primary"></i>
                    Tren Personal — 6 Bulan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="personalChart" style="height:160px; min-height:160px;"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ─── Baris 3: Chart Bisnis + Upcoming Tasks ────────────────── --}}
<div class="row">

    {{-- Chart Bisnis --}}
    <div class="col-lg-6 col-12">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1 text-warning"></i>
                    Tren Bisnis — 6 Bulan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="businessChart" style="height:160px; min-height:160px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Upcoming Tasks --}}
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check mr-1"></i> Tugas Mendekati Deadline
                </h3>
                <div class="card-tools">
                    <a href="{{ route('user.tasks.calendar') }}" class="btn btn-sm btn-default">
                        <i class="fas fa-calendar"></i> Kalender
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingTasks as $task)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="mr-3">
                            <span class="badge badge-{{ $task->priority_badge }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <a href="{{ route('user.tasks.show', $task->id) }}" class="text-dark font-weight-bold">
                                {{ $task->title }}
                            </a>
                            <div class="text-muted small">
                                <i class="fas fa-calendar-day mr-1"></i>
                                Due: {{ $task->due_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>
                        <span class="badge badge-{{ $task->status_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                        Tidak ada tugas mendekati deadline. 🎉
                    </div>
                @endforelse
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('user.tasks.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua Tugas
                </a>
            </div>
        </div>
    </div>

</div>

{{-- ─── Baris 4: Jurnal Terbaru ────────────────────────────────── --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book mr-1"></i> Jurnal Terbaru
                </h3>
                <div class="card-tools">
                    <a href="{{ route('user.journals.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Tulis Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    @forelse($latestJournals as $journal)
                        <div class="col-md-4">
                            <a href="{{ route('user.journals.show', $journal->id) }}"
                               class="d-flex align-items-center p-3 border-right text-dark text-decoration-none">
                                <div class="mr-3" style="font-size:1.5rem">{{ $journal->mood_emoji }}</div>
                                <div class="flex-grow-1">
                                    <strong class="d-block text-truncate" style="max-width:200px">
                                        {{ $journal->title }}
                                    </strong>
                                    <div class="text-muted small">
                                        {{ $journal->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 p-4 text-center text-muted">
                            <i class="fas fa-pen fa-2x mb-2 d-block"></i>
                            Belum ada jurnal. Mulai tulis hari ini!
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('user.journals.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua Jurnal
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ─── Helper fungsi buat chart ─────────────────────────────────
function makeLineChart(canvasId, labels, income, expense, incomeColor, expenseColor, bgColor) {
    new Chart(document.getElementById(canvasId).getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: income,
                    borderColor: incomeColor,
                    backgroundColor: bgColor,
                    borderWidth: 2, fill: true, tension: 0.3,
                    pointRadius: 3, pointHoverRadius: 5,
                },
                {
                    label: 'Pengeluaran',
                    data: expense,
                    borderColor: 'rgba(220,53,69,1)',
                    backgroundColor: 'rgba(220,53,69,0.08)',
                    borderWidth: 2, fill: true, tension: 0.3,
                    pointRadius: 3, pointHoverRadius: 5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 10 },
                        callback: v => {
                            if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                            if (v >= 1000)    return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                            return 'Rp ' + v;
                        }
                    }
                },
                x: { ticks: { font: { size: 10 } } }
            }
        }
    });
}

// ─── Chart Personal (biru) ────────────────────────────────────
makeLineChart(
    'personalChart',
    {!! $personalChart['labels'] !!},
    {!! $personalChart['income'] !!},
    {!! $personalChart['expense'] !!},
    'rgba(0,123,255,1)',
    'rgba(0,123,255,0.1)',
    'rgba(0,123,255,0.08)'
);

// ─── Chart Bisnis (kuning/orange) ─────────────────────────────
makeLineChart(
    'businessChart',
    {!! $businessChart['labels'] !!},
    {!! $businessChart['income'] !!},
    {!! $businessChart['expense'] !!},
    'rgba(255,193,7,1)',
    'rgba(255,193,7,0.1)',
    'rgba(255,193,7,0.08)'
);
</script>
@endpush