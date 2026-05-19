{{--
    FILE: resources/views/financial/index.blade.php
    Halaman keuangan dengan tab Personal | Bisnis
--}}
@extends('layouts.master')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Keuangan</li>
@endsection

@section('content')

{{-- ─── Tab Navigation ─────────────────────────────────────── --}}
<div class="card card-primary card-outline">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="financialTabs" role="tablist">

            {{-- Tab Personal --}}
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'personal' ? 'active' : '' }}"
                   href="{{ route('user.financial.index', ['tab' => 'personal', 'month' => $filterMonth]) }}"
                   style="border-radius: 0;">
                    <i class="fas fa-user mr-2"></i>
                    <strong>Personal</strong>
                    @if($personalSummary['balance'] != 0)
                        <span class="badge badge-{{ $personalSummary['balance'] >= 0 ? 'success' : 'danger' }} ml-2">
                            {{ $personalSummary['balance'] >= 0 ? '+' : '' }}Rp {{ number_format(abs($personalSummary['balance'])/1000, 0, ',', '.') }}rb
                        </span>
                    @endif
                </a>
            </li>

            {{-- Tab Bisnis --}}
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'business' ? 'active' : '' }}"
                   href="{{ route('user.financial.index', ['tab' => 'business', 'month' => $filterMonth]) }}"
                   style="border-radius: 0;">
                    <i class="fas fa-briefcase mr-2"></i>
                    <strong>Bisnis</strong>
                    @if($businessSummary['balance'] != 0)
                        <span class="badge badge-{{ $businessSummary['balance'] >= 0 ? 'success' : 'danger' }} ml-2">
                            {{ $businessSummary['balance'] >= 0 ? '+' : '' }}Rp {{ number_format(abs($businessSummary['balance'])/1000, 0, ',', '.') }}rb
                        </span>
                    @endif
                </a>
            </li>

            {{-- Tombol Tambah Transaksi --}}
            <li class="nav-item ml-auto d-flex align-items-center pr-3">
                <button type="button"
                        class="btn btn-{{ $activeTab === 'personal' ? 'primary' : 'warning' }} btn-sm"
                        data-toggle="modal"
                        data-target="#modalTambah">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah {{ $activeTab === 'personal' ? 'Transaksi Personal' : 'Transaksi Bisnis' }}
                </button>
            </li>

        </ul>
    </div>

    <div class="card-body">

        {{-- ─── Summary Cards ─────────────────────────────────── --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="info-box bg-success mb-0 shadow-sm">
                    <span class="info-box-icon"><i class="fas fa-arrow-circle-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pemasukan</span>
                        <span class="info-box-number">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                        <span class="progress-description">
                            {{ $activeTab === 'personal' ? '👤 Personal' : '💼 Bisnis' }}
                            &bull; {{ \Carbon\Carbon::createFromFormat('Y-m', $filterMonth)->format('F Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-danger mb-0 shadow-sm">
                    <span class="info-box-icon"><i class="fas fa-arrow-circle-down"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pengeluaran</span>
                        <span class="info-box-number">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                        <span class="progress-description">
                            {{ $activeTab === 'personal' ? '👤 Personal' : '💼 Bisnis' }}
                            &bull; {{ \Carbon\Carbon::createFromFormat('Y-m', $filterMonth)->format('F Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box {{ $balance >= 0 ? 'bg-info' : 'bg-warning' }} mb-0 shadow-sm">
                    <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Saldo</span>
                        <span class="info-box-number">Rp {{ number_format(abs($balance), 0, ',', '.') }}</span>
                        <span class="progress-description">
                            {{ $balance >= 0 ? '✅ Surplus' : '⚠️ Defisit' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Chart Tren 6 Bulan ─────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Tren 6 Bulan —
                    {{ $activeTab === 'personal' ? '👤 Personal' : '💼 Bisnis' }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="trendChart" style="height:200px; min-height:200px;"></canvas>
            </div>
        </div>

        {{-- ─── Filter + Tabel ─────────────────────────────────── --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" action="{{ route('user.financial.index') }}" class="form-inline">
                    {{-- Pertahankan tab aktif saat filter --}}
                    <input type="hidden" name="tab" value="{{ $activeTab }}">

                    <div class="form-group mr-2 mb-2">
                        <label class="mr-1 small font-weight-bold">Bulan</label>
                        <input type="month" name="month"
                               class="form-control form-control-sm"
                               value="{{ $filterMonth }}"
                               max="{{ now()->format('Y-m') }}">
                    </div>

                    <div class="form-group mr-2 mb-2">
                        <label class="mr-1 small font-weight-bold">Tipe</label>
                        <select name="type" class="form-control form-control-sm">
                            <option value="all"     {{ $filterType === 'all'     ? 'selected' : '' }}>Semua</option>
                            <option value="income"  {{ $filterType === 'income'  ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ $filterType === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary mr-2 mb-2">
                        <i class="fas fa-search mr-1"></i> Tampilkan
                    </button>
                    <a href="{{ route('user.financial.index', ['tab' => $activeTab]) }}"
                       class="btn btn-sm btn-default mb-2">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                </form>
            </div>
            <div class="col-md-4 text-right d-flex align-items-center justify-content-end">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('user.financial.export.pdf', ['tab' => $activeTab, 'month' => $filterMonth, 'type' => $filterType]) }}"
                       class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                    <a href="{{ route('user.financial.export.excel', ['tab' => $activeTab, 'month' => $filterMonth, 'type' => $filterType]) }}"
                       class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── Tabel Transaksi ────────────────────────────────── --}}
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-{{ $activeTab === 'personal' ? 'primary' : 'warning' }}
                              {{ $activeTab === 'personal' ? 'bg-primary text-white' : 'bg-warning' }}">
                    <tr>
                        <th style="width:13%">Tanggal</th>
                        <th style="width:12%">Tipe</th>
                        <th style="width:38%">Keterangan</th>
                        <th style="width:20%" class="text-right">Jumlah</th>
                        <th style="width:17%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $rec)
                    <tr>
                        <td class="small">{{ $rec->recorded_at->format('d M Y') }}</td>
                        <td>
                            @if($rec->type === 'income')
                                <span class="badge badge-success">
                                    <i class="fas fa-arrow-up mr-1"></i>Masuk
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-arrow-down mr-1"></i>Keluar
                                </span>
                            @endif
                        </td>
                        <td>{{ $rec->description }}</td>
                        <td class="text-right font-weight-bold {{ $rec->type === 'income' ? 'text-success' : 'text-danger' }}">
                            {{ $rec->type === 'income' ? '+' : '-' }}Rp {{ number_format($rec->amount, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button"
                                        class="btn btn-outline-primary btn-edit"
                                        data-id="{{ $rec->id }}"
                                        data-type="{{ $rec->type }}"
                                        data-amount="{{ $rec->amount }}"
                                        data-description="{{ $rec->description }}"
                                        data-recorded_at="{{ $rec->recorded_at->format('Y-m-d') }}"
                                        data-toggle="modal"
                                        data-target="#modalEdit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button"
                                        class="btn btn-outline-danger"
                                        onclick="confirmDelete({{ $rec->id }}, '{{ addslashes($rec->description) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-receipt fa-3x mb-3 d-block"></i>
                            Belum ada transaksi {{ $activeTab === 'personal' ? 'personal' : 'bisnis' }}.
                            <br>
                            <button type="button"
                                    class="btn btn-{{ $activeTab === 'personal' ? 'primary' : 'warning' }} btn-sm mt-2"
                                    data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus mr-1"></i> Tambah Sekarang
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="mt-3">
            {{ $records->withQueryString()->links() }}
        </div>
        @endif

    </div>{{-- /.card-body --}}
</div>{{-- /.card --}}


{{-- ============================================================ --}}
{{-- MODAL: Tambah Transaksi                                       --}}
{{-- category sudah otomatis sesuai tab aktif (hidden input)      --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-{{ $activeTab === 'personal' ? 'primary' : 'warning' }} text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Transaksi {{ $activeTab === 'personal' ? 'Personal' : 'Bisnis' }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.financial.store') }}" method="POST">
                @csrf
                {{-- Category otomatis dari tab aktif — tidak bisa diubah user --}}
                <input type="hidden" name="category" value="{{ $activeTab }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipe <span class="text-danger">*</span></label>
                        <select name="type"
                                class="form-control @error('type') is-invalid @enderror"
                                required>
                            <option value="income"  {{ old('type') == 'income'  ? 'selected' : '' }}>📈 Pemasukan</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>📉 Pengeluaran</option>
                        </select>
                        @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Jumlah (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}"
                                   placeholder="0" min="1" step="1" required>
                            @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan <span class="text-danger">*</span></label>
                        <input type="text" name="description"
                               class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description') }}"
                               placeholder="{{ $activeTab === 'personal' ? 'Contoh: Gaji, Bayar listrik...' : 'Contoh: Invoice klien, Sewa kantor...' }}"
                               required>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="recorded_at"
                               class="form-control @error('recorded_at') is-invalid @enderror"
                               value="{{ old('recorded_at', now()->toDateString()) }}"
                               max="{{ now()->toDateString() }}" required>
                        @error('recorded_at') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-{{ $activeTab === 'personal' ? 'primary' : 'warning' }}">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ============================================================ --}}
{{-- MODAL: Edit Transaksi                                         --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Edit Transaksi
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="category" value="{{ $activeTab }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipe <span class="text-danger">*</span></label>
                        <select name="type" id="edit_type" class="form-control" required>
                            <option value="income">📈 Pemasukan</option>
                            <option value="expense">📉 Pengeluaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="amount" id="edit_amount"
                                   class="form-control" min="1" step="1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="edit_description"
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-0">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="recorded_at" id="edit_recorded_at"
                               class="form-control" max="{{ now()->toDateString() }}" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Form hapus tersembunyi --}}
<form id="deleteForm" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

{{-- Buka modal otomatis jika ada validation error --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#modalTambah').modal('show');
    });
</script>
@endif

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ─── Chart Tren 6 Bulan ───────────────────────────────────────
const trendLabels  = {!! json_encode($trendData['labels']) !!};
const trendIncome  = {!! json_encode($trendData['income']) !!};
const trendExpense = {!! json_encode($trendData['expense']) !!};
const activeTab    = '{{ $activeTab }}';

const primaryColor = activeTab === 'personal'
    ? { income: 'rgba(0,123,255,1)', expense: 'rgba(220,53,69,1)' }
    : { income: 'rgba(255,193,7,1)', expense: 'rgba(220,53,69,1)' };

new Chart(document.getElementById('trendChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [
            {
                label: 'Pemasukan',
                data: trendIncome,
                borderColor: primaryColor.income,
                backgroundColor: activeTab === 'personal'
                    ? 'rgba(0,123,255,0.1)' : 'rgba(255,193,7,0.1)',
                borderWidth: 2, fill: true, tension: 0.3,
                pointRadius: 4, pointHoverRadius: 6,
            },
            {
                label: 'Pengeluaran',
                data: trendExpense,
                borderColor: primaryColor.expense,
                backgroundColor: 'rgba(220,53,69,0.1)',
                borderWidth: 2, fill: true, tension: 0.3,
                pointRadius: 4, pointHoverRadius: 6,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'top' },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.dataset.label + ': Rp ' +
                                  ctx.parsed.y.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => {
                        if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                        if (v >= 1000)    return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                        return 'Rp ' + v;
                    }
                }
            }
        }
    }
});

// ─── Populate Modal Edit ──────────────────────────────────────
document.querySelectorAll('.btn-edit').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('editForm').action = '/app/financial/' + this.dataset.id;
        document.getElementById('edit_type').value        = this.dataset.type;
        document.getElementById('edit_amount').value      = this.dataset.amount;
        document.getElementById('edit_description').value = this.dataset.description;
        document.getElementById('edit_recorded_at').value = this.dataset.recorded_at;
    });
});

// ─── Konfirmasi Hapus ─────────────────────────────────────────
function confirmDelete(id, desc) {
    if (confirm('Hapus transaksi "' + desc + '"?\nTindakan ini tidak bisa dibatalkan.')) {
        var form = document.getElementById('deleteForm');
        form.action = '/app/financial/' + id;
        form.submit();
    }
}
</script>
@endpush