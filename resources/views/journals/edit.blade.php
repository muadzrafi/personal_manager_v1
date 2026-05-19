@extends('layouts.master')
 
@section('title', 'Edit Jurnal')
@section('page-title', 'Edit Jurnal')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.journals.index') }}">Jurnal</a></li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.journals.show', $journal->id) }}">{{ Str::limit($journal->title, 30) }}</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
 
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-container { font-size: 15px; }
    .ql-editor { min-height: 300px; }
    .mood-option { display: none; }
    .mood-option + label {
        cursor: pointer; font-size: 1.8rem; margin: 0 5px;
        opacity: 0.4; transition: opacity .2s, transform .2s;
    }
    .mood-option:checked + label { opacity: 1; transform: scale(1.25); }
</style>
@endpush
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Jurnal</h3>
    </div>
 
    <form action="{{ route('user.journals.update', $journal->id) }}" method="POST" id="journalForm">
        @csrf @method('PUT')
        <div class="card-body">
 
            {{-- Mood --}}
            <div class="form-group">
                <label class="d-block">Mood</label>
                <div class="py-1">
                    @foreach(['great' => '😄', 'good' => '🙂', 'neutral' => '😐', 'bad' => '😔', 'terrible' => '😢'] as $val => $emoji)
                        <input type="radio" name="mood" id="mood_{{ $val }}" value="{{ $val }}"
                               class="mood-option"
                               {{ old('mood', $journal->mood) == $val ? 'checked' : '' }}>
                        <label for="mood_{{ $val }}" title="{{ ucfirst($val) }}">{{ $emoji }}</label>
                    @endforeach
                </div>
            </div>
 
            {{-- Judul --}}
            <div class="form-group">
                <label for="title">Judul Jurnal <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title"
                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                       value="{{ old('title', $journal->title) }}" required>
                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
 
            {{-- Konten --}}
            <div class="form-group">
                <label>Isi Jurnal <span class="text-danger">*</span></label>
                {{-- Quill akan diisi dengan konten existing lewat JS --}}
                <div id="quillEditor"></div>
                <input type="hidden" name="content" id="content" value="{{ old('content', $journal->content) }}">
                @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
 
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('user.journals.show', $journal->id) }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Batal
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
 
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
const quill = new Quill('#quillEditor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['blockquote'],
            [{ 'color': [] }],
            ['clean'],
        ]
    }
});
 
// Load konten existing ke dalam Quill editor
const existingContent = document.getElementById('content').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}
 
document.getElementById('journalForm').addEventListener('submit', function(e) {
    const stripped = quill.getText().trim();
    if (stripped.length < 10) {
        e.preventDefault();
        alert('Isi jurnal minimal 10 karakter.');
        return;
    }
    document.getElementById('content').value = quill.root.innerHTML;
});
</script>
@endpush