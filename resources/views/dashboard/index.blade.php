{{-- FILE: resources/views/dashboard/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', '')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Welcome Banner --}}
<div class="pm-welcome-banner">
    <h4>Selamat datang, {{ auth()->user()->name }} 👋</h4>
    <p>{{ now()->translatedFormat('l, d F Y') }} — Pantau produktivitas dan keuangan Anda hari ini.</p>
</div>

{{-- Stat Cards --}}
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="pm-stat-card">
            <div class="pm-stat-icon teal">💾<i class="fas fa-tasks"></i></div>
            <div>
                <div class="pm-stat-label">Total Tugas</div>
                <div class="pm-stat-value">{{ $stats['total_tasks'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="pm-stat-card">
            <div class="pm-stat-icon orange">🗒️<i class="fas fa-clock"></i></div>
            <div>
                <div class="pm-stat-label">Tugas Pending</div>
                <div class="pm-stat-value">{{ $stats['pending_tasks'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="pm-stat-card">
            <div class="pm-stat-icon blue">📖<i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pm-stat-label">Tugas Selesai</div>
                <div class="pm-stat-value">{{ $stats['completed_tasks'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="pm-stat-card">
            <div class="pm-stat-icon purple">📜<i class="fas fa-book-open"></i></div>
            <div>
                <div class="pm-stat-label">Total Jurnal</div>
                <div class="pm-stat-value">{{ $stats['total_journals'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Summary + Chart Personal --}}
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-chart-line mr-1" style="color:#1D9E75"></i> Tren Personal — 6 Bulan</span>
            </div>
            <div class="card-body">
                <div style="position:relative; height:180px; width:100%;">
                    <canvas id="personalChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-chart-bar mr-1" style="color:#F59E0B"></i> Tren Bisnis — 6 Bulan</span>
            </div>
            <div class="card-body">
                <div style="position:relative; height:180px; width:100%;">
                    <canvas id="businessChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Bisnis + Tasks --}}
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="card-title"><i class="fas fa-user mr-1" style="color:#1D9E75"></i> Personal</span>
                <a href="{{ route('user.financial.index', ['tab' => 'personal']) }}" class="btn btn-sm btn-default" style="padding:3px 8px;font-size:11px;">Detail →</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-arrow-up text-success mr-1"></i>Masuk</span>
                        <strong class="text-success" style="font-size:12.5px;">Rp {{ number_format($personalIncome,0,',','.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-arrow-down text-danger mr-1"></i>Keluar</span>
                        <strong class="text-danger" style="font-size:12.5px;">Rp {{ number_format($personalExpense,0,',','.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-balance-scale mr-1"></i>Saldo</span>
                        <strong class="{{ $personalBalance >= 0 ? 'text-success' : 'text-danger' }}" style="font-size:12.5px;">Rp {{ number_format(abs($personalBalance),0,',','.') }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="card-title"><i class="fas fa-briefcase mr-1" style="color:#F59E0B"></i> Bisnis</span>
                <a href="{{ route('user.financial.index', ['tab' => 'business']) }}" class="btn btn-sm btn-default" style="padding:3px 8px;font-size:11px;">Detail →</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-arrow-up text-success mr-1"></i>Masuk</span>
                        <strong class="text-success" style="font-size:12.5px;">Rp {{ number_format($businessIncome,0,',','.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-arrow-down text-danger mr-1"></i>Keluar</span>
                        <strong class="text-danger" style="font-size:12.5px;">Rp {{ number_format($businessExpense,0,',','.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span style="font-size:12.5px;color:#6B7280;"><i class="fas fa-balance-scale mr-1"></i>Saldo</span>
                        <strong class="{{ $businessBalance >= 0 ? 'text-success' : 'text-danger' }}" style="font-size:12.5px;">Rp {{ number_format(abs($businessBalance),0,',','.') }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="card-title"><i class="fas fa-calendar-check mr-1"></i> Deadline Terdekat</span>
                <a href="{{ route('user.tasks.calendar') }}" class="btn btn-sm btn-default"><i class="fas fa-calendar mr-1"></i> Kalender</a>
            </div>
            <div class="card-body p-0">
                <div style="max-height: 144px; overflow-y: auto;">
                    @forelse($upcomingTasks as $task)
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="mr-3">
                            <span class="badge badge-{{ $task->priority_badge }}">{{ ucfirst($task->priority) }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <a href="{{ route('user.tasks.show', $task->id) }}" class="d-block text-dark" style="font-size:13px;font-weight:600;">
                                {{ $task->title }}
                            </a>
                            <div style="font-size:11.5px;color:#9CA3AF;">
                                <i class="fas fa-calendar-day mr-1"></i>{{ $task->due_date?->format('d M Y') ?? 'Tanpa deadline' }}
                            </div>
                        </div>
                        <span class="badge badge-{{ $task->status_badge }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                        <span style="font-size:13px;">Tidak ada deadline terdekat 🎉</span>
                    </div>
                    @endforelse
                </div>
            </div>
            @if($upcomingTasks->count() > 0)
            <div class="card-footer text-right">
                <a href="{{ route('user.tasks.index') }}" class="btn btn-sm btn-primary">Lihat Semua Tugas</a>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Jurnal --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="card-title"><i class="fas fa-book mr-1"></i> Jurnal Terbaru</span>
                <a href="{{ route('user.journals.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-1"></i> Tulis Baru</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($latestJournals as $journal)
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('user.journals.show', $journal->id) }}" class="d-block text-dark text-decoration-none p-3"
                           style="background:#F9FAFB;border-radius:12px;border:1px solid #E5E7EB;transition:all 0.2s;"
                           onmouseover="this.style.background='#E1F5EE';this.style.borderColor='#1D9E75'"
                           onmouseout="this.style.background='#F9FAFB';this.style.borderColor='#E5E7EB'">
                            <div class="d-flex align-items-center mb-2">
                                <span style="font-size:1.4rem;margin-right:10px;">{{ $journal->mood_emoji }}</span>
                                <strong style="font-size:13px;font-weight:600;">{{ Str::limit($journal->title, 30) }}</strong>
                            </div>
                            <div style="font-size:11.5px;color:#9CA3AF;"><i class="fas fa-clock mr-1"></i>{{ $journal->created_at->format('d M Y, H:i') }}</div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center py-3 text-muted">
                        <i class="fas fa-pen fa-2x mb-2 d-block"></i>
                        <span style="font-size:13px;">Belum ada jurnal.</span>
                    </div>
                    @endforelse
                </div>
            </div>
            @if($latestJournals->count() > 0)
            <div class="card-footer text-right">
                <a href="{{ route('user.journals.index') }}" class="btn btn-sm btn-default">Lihat Semua</a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
Chart.defaults.font.size   = 11;

function makeChart(id, labels, income, expense, lineColor, bgColor) {
    var ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                { label:'Pemasukan', data:income, borderColor:lineColor, backgroundColor:bgColor, borderWidth:2.5, fill:true, tension:0.4, pointRadius:3, pointHoverRadius:6, pointBackgroundColor:lineColor },
                { label:'Pengeluaran', data:expense, borderColor:'rgba(239,68,68,0.9)', backgroundColor:'rgba(239,68,68,0.06)', borderWidth:2.5, fill:true, tension:0.4, pointRadius:3, pointHoverRadius:6 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode:'index', intersect:false },
            plugins: {
                legend: { position:'top', labels:{ boxWidth:8, usePointStyle:true, pointStyle:'circle', padding:12 } },
                tooltip: { callbacks: { label: function(c){ return c.dataset.label+': Rp '+c.parsed.y.toLocaleString('id-ID'); } } }
            },
            scales: {
                y: { beginAtZero:true, grid:{ color:'rgba(0,0,0,0.04)' }, ticks:{ callback:function(v){ if(v>=1000000) return 'Rp '+(v/1000000).toFixed(1)+'jt'; if(v>=1000) return 'Rp '+(v/1000).toFixed(0)+'rb'; return 'Rp '+v; } } },
                x: { grid:{ display:false } }
            }
        }
    });
}

makeChart('personalChart', {!! $personalChart['labels'] !!}, {!! $personalChart['income'] !!}, {!! $personalChart['expense'] !!}, 'rgba(29,158,117,0.9)', 'rgba(29,158,117,0.08)');
makeChart('businessChart', {!! $businessChart['labels'] !!}, {!! $businessChart['income'] !!}, {!! $businessChart['expense'] !!}, 'rgba(245,158,11,0.9)', 'rgba(245,158,11,0.08)');
</script>
@endpush