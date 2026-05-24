@extends('layouts.master')
@section('title','Tugas Baru')
@section('page-title','Tambah Tugas Baru')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.tasks.index') }}">Tugas</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
@endsection
@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header" style="border-top:3px solid #1D9E75;">
        <span class="card-title"><i class="fas fa-plus-circle mr-2" style="color:#1D9E75;"></i>Form Tugas Baru</span>
    </div>
    <form action="{{ route('user.tasks.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Judul Tugas <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="Apa yang perlu dilakukan?"
                       autofocus required>
                @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Detail tambahan (opsional)">{{ old('description') }}</textarea>
                @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Prioritas <span class="text-danger">*</span></label>
                        <select name="priority" class="form-control @error('priority') is-invalid @enderror" required>
                            <option value="low"    {{ old('priority')=='low'    ?'selected':'' }}>🟢 Rendah</option>
                            <option value="medium" {{ old('priority','medium')=='medium'?'selected':'' }}>🟡 Sedang</option>
                            <option value="high"   {{ old('priority')=='high'   ?'selected':'' }}>🔴 Tinggi</option>
                        </select>
                        @error('priority')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="pending"     {{ old('status','pending')=='pending'    ?'selected':'' }}>⏳ Pending</option>
                            <option value="in_progress" {{ old('status')=='in_progress'          ?'selected':'' }}>🔄 In Progress</option>
                            <option value="completed"   {{ old('status')=='completed'            ?'selected':'' }}>✅ Selesai</option>
                            <option value="cancelled"   {{ old('status')=='cancelled'            ?'selected':'' }}>❌ Dibatalkan</option>
                        </select>
                        @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Deadline</label>
                        <input type="date" name="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date') }}"
                               min="{{ now()->toDateString() }}">
                        @error('due_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('user.tasks.index') }}" class="btn btn-default">← Kembali</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan Tugas
            </button>
        </div>
    </form>
</div>
</div>
</div>
@endsection