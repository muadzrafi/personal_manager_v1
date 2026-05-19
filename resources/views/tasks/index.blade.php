@extends('layouts.master')
 
@section('title', 'Daftar Tugas')
@section('page-title', 'Manajemen Tugas')
 
@section('breadcrumbs')
    <li class="breadcrumb-item active">Tugas</li>
@endsection
 
@section('content')
 
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Daftar Tugas</h3>
        <a href="{{ route('user.tasks.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tugas Baru
        </a>
    </div>
 
    {{-- Filter Bar --}}
    <div class="card-body border-bottom pb-3">
        <form method="GET" action="{{ route('user.tasks.index') }}" class="form-inline flex-wrap gap-2">
            <select name="status" class="form-control form-control-sm mr-2 mb-2">
                <option value="">Semua Status</option>
                @foreach(['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="priority" class="form-control form-control-sm mr-2 mb-2">
                <option value="">Semua Prioritas</option>
                @foreach(['high' => 'Tinggi', 'medium' => 'Sedang', 'low' => 'Rendah'] as $val => $label)
                    <option value="{{ $val }}" {{ request('priority') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-default mr-2 mb-2">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('user.tasks.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-times mr-1"></i> Reset
            </a>
        </form>
    </div>
 
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width:35%">Judul</th>
                        <th style="width:12%">Prioritas</th>
                        <th style="width:12%">Status</th>
                        <th style="width:15%">Deadline</th>
                        <th style="width:15%">Dibuat</th>
                        <th style="width:11%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>
                            <a href="{{ route('user.tasks.show', $task->id) }}" class="font-weight-bold text-dark">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                                <div class="text-muted small text-truncate" style="max-width:280px">
                                    {{ $task->description }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $task->priority_badge }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $task->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td>
                            @if($task->due_date)
                                <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger font-weight-bold' : '' }}">
                                    <i class="fas fa-calendar-day mr-1"></i>
                                    {{ $task->due_date->format('d M Y') }}
                                    @if($task->due_date->isToday() && $task->status !== 'completed')
                                        <span class="badge badge-warning ml-1">Hari ini!</span>
                                    @elseif($task->due_date->isPast() && $task->status !== 'completed')
                                        <span class="badge badge-danger ml-1">Terlambat</span>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $task->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.tasks.edit', $task->id) }}"
                                   class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        title="Hapus"
                                        onclick="confirmDelete({{ $task->id }}, '{{ addslashes($task->title) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Belum ada tugas.
                            <a href="{{ route('user.tasks.create') }}">Buat tugas pertama Anda!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
 
    @if($tasks->hasPages())
    <div class="card-footer clearfix">
        {{ $tasks->withQueryString()->links() }}
    </div>
    @endif
</div>
 
{{-- Form hapus tersembunyi --}}
<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>
 
@endsection
 
@push('scripts')
<script>
function confirmDelete(id, title) {
    if (confirm('Hapus tugas "' + title + '"? Tindakan ini tidak bisa dibatalkan.')) {
        const form = document.getElementById('deleteForm');
        form.action = '/app/tasks/' + id;
        form.submit();
    }
}
</script>
@endpush