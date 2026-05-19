@extends('layouts.master')
 
@section('title', 'Edit Tugas')
@section('page-title', 'Edit Tugas')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.tasks.index') }}">Tugas</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Tugas</h3>
    </div>
 
    <form action="{{ route('user.tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
 
            <div class="form-group">
                <label for="title">Judul Tugas <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $task->title) }}" required>
                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
 
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
 
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="priority">Prioritas <span class="text-danger">*</span></label>
                        <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                            <option value="low"    {{ old('priority', $task->priority) == 'low'    ? 'selected' : '' }}>🟢 Rendah</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                            <option value="high"   {{ old('priority', $task->priority) == 'high'   ? 'selected' : '' }}>🔴 Tinggi</option>
                        </select>
                        @error('priority') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="pending"     {{ old('status', $task->status) == 'pending'     ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                            <option value="completed"   {{ old('status', $task->status) == 'completed'   ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="cancelled"   {{ old('status', $task->status) == 'cancelled'   ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                        @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="due_date">Deadline</label>
                        <input type="date" name="due_date" id="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                        @error('due_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
 
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('user.tasks.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
</div>
</div>
@endsection