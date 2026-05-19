@extends('layouts.master')
 
@section('title', $task->title)
@section('page-title', 'Detail Tugas')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.tasks.index') }}">Tugas</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
 
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ $task->title }}</h3>
            <div>
                <a href="{{ route('user.tasks.edit', $task->id) }}" class="btn btn-sm btn-warning mr-1">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="confirmDelete({{ $task->id }}, '{{ addslashes($task->title) }}')">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-4">
                    <div class="text-muted small mb-1">Status</div>
                    <span class="badge badge-{{ $task->status_badge }} badge-lg px-3 py-2">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small mb-1">Prioritas</div>
                    <span class="badge badge-{{ $task->priority_badge }} badge-lg px-3 py-2">
                        {{ ucfirst($task->priority) }}
                    </span>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small mb-1">Deadline</div>
                    @if($task->due_date)
                        <strong class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger' : '' }}">
                            <i class="fas fa-calendar-day mr-1"></i>
                            {{ $task->due_date->translatedFormat('d F Y') }}
                        </strong>
                    @else
                        <span class="text-muted">Tidak ada deadline</span>
                    @endif
                </div>
            </div>
 
            @if($task->description)
            <hr>
            <div class="form-group mb-0">
                <label class="text-muted small">Deskripsi</label>
                <p class="mb-0">{{ $task->description }}</p>
            </div>
            @endif
 
            <hr>
            <div class="row text-muted small">
                <div class="col-sm-6">
                    <i class="fas fa-clock mr-1"></i> Dibuat: {{ $task->created_at->format('d M Y, H:i') }}
                </div>
                <div class="col-sm-6">
                    <i class="fas fa-pencil-alt mr-1"></i> Diperbarui: {{ $task->updated_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.tasks.index') }}" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
 
</div>
</div>
 
<form id="deleteForm" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>
@endsection
 
@push('scripts')
<script>
function confirmDelete(id, title) {
    if (confirm('Hapus tugas "' + title + '"?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/app/tasks/' + id;
        form.submit();
    }
}
</script>
@endpush