@extends('layouts.master')
 
@section('title', 'Tugas Baru')
@section('page-title', 'Tambah Tugas Baru')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.tasks.index') }}">Tugas</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
@endsection
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Form Tugas Baru</h3>
    </div>
 
    <form action="{{ route('user.tasks.store') }}" method="POST">
        @csrf
        <div class="card-body">
 
            {{-- Judul --}}
            <div class="form-group">
                <label for="title">Judul Tugas <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="Contoh: Meeting dengan klien, Belajar Laravel..."
                       autofocus required>
                @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
 
            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Detail tambahan tentang tugas ini (opsional)">{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
 
            <div class="row">
                {{-- Prioritas --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="priority">Prioritas <span class="text-danger">*</span></label>
                        <select name="priority" id="priority"
                                class="form-control @error('priority') is-invalid @enderror" required>
                            <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>🟢 Rendah</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                            <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>🔴 Tinggi</option>
                        </select>
                        @error('priority') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
 
                {{-- Status --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror" required>
                            <option value="pending"     {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                            <option value="completed"   {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="cancelled"   {{ old('status') == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                        @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
 
                {{-- Deadline --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="due_date">Deadline</label>
                        <input type="date" name="due_date" id="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date') }}"
                               min="{{ now()->toDateString() }}">
                        @error('due_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="text-muted">Kosongkan jika tidak ada deadline.</small>
                    </div>
                </div>
            </div>
 
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('user.tasks.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan Tugas
            </button>
        </div>
    </form>
</div>
</div>
</div>
@endsection