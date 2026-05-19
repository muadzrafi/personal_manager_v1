<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body        { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header     { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2  { margin: 0; font-size: 18px; }
        .header p   { margin: 3px 0; color: #666; font-size: 11px; }
        .summary    { margin-bottom: 20px; }
        .summary table { width: 40%; }
        .summary td { padding: 3px 8px; }
        .summary .label { color: #666; }
        .summary .income  { color: #1e7e34; font-weight: bold; }
        .summary .expense { color: #c82333; font-weight: bold; }
        .summary .balance { color: #0056b3; font-weight: bold; }
        table.records { width: 100%; border-collapse: collapse; }
        table.records th {
            background: #343a40; color: white; padding: 6px 8px;
            text-align: left; font-size: 11px;
        }
        table.records td { padding: 5px 8px; border-bottom: 1px solid #dee2e6; font-size: 11px; }
        .income-row  { background: #d4edda; }
        .expense-row { background: #f8d7da; }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }
        .badge-income  { color: #1e7e34; font-weight: bold; }
        .badge-expense { color: #c82333; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; color: #999; font-size: 10px; }
    </style>
</head>
<body>
 
<div class="header">
    <h2>LAPORAN KEUANGAN</h2>
    <p>{{ \Carbon\Carbon::createFromFormat('Y-m', $filterMonth)->format('F Y') }}</p>
    <p>Pemilik: <strong>{{ $user->name }}</strong> | Diekspor: {{ now()->format('d M Y, H:i') }}</p>
</div>
 
<div class="summary">
    <table>
        <tr>
            <td class="label">Total Pemasukan</td>
            <td class="income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total Pengeluaran</td>
            <td class="expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Saldo</td>
            <td class="balance">Rp {{ number_format($balance, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
 
<table class="records">
    <thead>
        <tr>
            <th style="width:4%">No</th>
            <th style="width:12%">Tanggal</th>
            <th style="width:12%">Tipe</th>
            <th style="width:12%">Kategori</th>
            <th style="width:40%">Keterangan</th>
            <th style="width:20%" class="text-right">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $rec)
        <tr class="{{ $rec->type === 'income' ? 'income-row' : 'expense-row' }}">
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $rec->recorded_at->format('d/m/Y') }}</td>
            <td class="{{ $rec->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                {{ $rec->type === 'income' ? '▲ Masuk' : '▼ Keluar' }}
            </td>
            <td>{{ ucfirst($rec->category) }}</td>
            <td>{{ $rec->description }}</td>
            <td class="text-right">Rp {{ number_format($rec->amount, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada transaksi.</td>
        </tr>
        @endforelse
    </tbody>
</table>
 
<div class="footer">
    Dokumen ini dibuat otomatis oleh Personal Manager App • {{ now()->format('d M Y H:i') }}
</div>
 
</body>
</html>
 
 
{{--
    FILE: resources/views/search/index.blade.php
    Halaman hasil pencarian global
--}}
@extends('layouts.master')
 
@section('title', 'Pencarian')
@section('page-title', 'Hasil Pencarian')
 
@section('breadcrumbs')
    <li class="breadcrumb-item active">Pencarian</li>
@endsection
 
@section('content')
 
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('user.search') }}">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control"
                       placeholder="Cari tugas, keuangan, atau jurnal..."
                       value="{{ $query }}" autofocus>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
 
@if(strlen($query) >= 2)
 
    <p class="text-muted mb-3">
        Ditemukan <strong>{{ $total }} hasil</strong> untuk kata kunci
        "<strong>{{ $query }}</strong>"
    </p>
 
    {{-- ─── Hasil: Tugas ─────────────────────────────────────── --}}
    @if($tasks->count() > 0)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tasks mr-2 text-primary"></i>
                Tugas ({{ $tasks->count() }})
            </h3>
        </div>
        <div class="card-body p-0">
            @foreach($tasks as $task)
            <a href="{{ route('user.tasks.show', $task->id) }}"
               class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none hover-item">
                <div class="mr-3">
                    <span class="badge badge-{{ $task->priority_badge }}">{{ ucfirst($task->priority) }}</span>
                </div>
                <div class="flex-grow-1">
                    <strong>{!! str_ireplace($query, '<mark>'.$query.'</mark>', e($task->title)) !!}</strong>
                    @if($task->description)
                        <div class="text-muted small text-truncate">
                            {!! str_ireplace($query, '<mark>'.$query.'</mark>', e(Str::limit($task->description, 100))) !!}
                        </div>
                    @endif
                </div>
                <div class="text-muted small ml-2">
                    {{ $task->due_date?->format('d M Y') ?? '—' }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
 
    {{-- ─── Hasil: Keuangan ──────────────────────────────────── --}}
    @if($records->count() > 0)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-wallet mr-2 text-success"></i>
                Keuangan ({{ $records->count() }})
            </h3>
        </div>
        <div class="card-body p-0">
            @foreach($records as $rec)
            <a href="{{ route('user.financial.index') }}"
               class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none hover-item">
                <div class="mr-3">
                    <span class="badge badge-{{ $rec->type === 'income' ? 'success' : 'danger' }}">
                        {{ $rec->type === 'income' ? '▲ Masuk' : '▼ Keluar' }}
                    </span>
                </div>
                <div class="flex-grow-1">
                    <strong>{!! str_ireplace($query, '<mark>'.$query.'</mark>', e($rec->description)) !!}</strong>
                    <div class="text-muted small">{{ $rec->recorded_at->format('d M Y') }} • {{ ucfirst($rec->category) }}</div>
                </div>
                <div class="font-weight-bold {{ $rec->type === 'income' ? 'text-success' : 'text-danger' }} ml-2">
                    Rp {{ number_format($rec->amount, 0, ',', '.') }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
 
    {{-- ─── Hasil: Jurnal ────────────────────────────────────── --}}
    @if($journals->count() > 0)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-book-open mr-2 text-warning"></i>
                Jurnal ({{ $journals->count() }})
            </h3>
        </div>
        <div class="card-body p-0">
            @foreach($journals as $journal)
            <a href="{{ route('user.journals.show', $journal->id) }}"
               class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none hover-item">
                <div class="mr-3" style="font-size:1.3rem">{{ $journal->mood_emoji }}</div>
                <div class="flex-grow-1">
                    <strong>{!! str_ireplace($query, '<mark>'.$query.'</mark>', e($journal->title)) !!}</strong>
                    <div class="text-muted small">{{ $journal->created_at->format('d M Y, H:i') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
 
    {{-- Tidak ada hasil --}}
    @if($total === 0)
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-search fa-3x mb-3 d-block"></i>
            <h5>Tidak ada hasil untuk "{{ $query }}"</h5>
            <p>Coba kata kunci yang berbeda.</p>
        </div>
    </div>
    @endif
 
@elseif(strlen($query) > 0)
    <div class="alert alert-warning">
        <i class="fas fa-info-circle mr-2"></i>
        Kata kunci minimal 2 karakter.
    </div>
@endif
 
@endsection
 
@push('styles')
<style>
    .hover-item:hover { background: #f8f9fa; }
    mark { background: #fff3cd; padding: 0 2px; border-radius: 2px; }
</style>
@endpush