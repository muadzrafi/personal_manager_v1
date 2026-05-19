@extends('layouts.master')
 
@section('title', 'Tulis Jurnal')
@section('page-title', 'Tulis Jurnal Baru')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.journals.index') }}">Jurnal</a></li>
    <li class="breadcrumb-item active">Tulis Baru</li>
@endsection
 
@push('styles')
{{-- Quill.js Snow theme --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-container { font-size: 15px; }
    .ql-editor { min-height: 300px; }
    /* Mood selector styling */
    .mood-option { display: none; }
    .mood-option + label {
        cursor: pointer;
        font-size: 1.8rem;
        margin: 0 5px;
        opacity: 0.4;
        transition: opacity .2s, transform .2s;
    }
    .mood-option:checked + label { opacity: 1; transform: scale(1.25); }
</style>
@endpush
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-pen-nib mr-2"></i>Jurnal Baru</h3>
        <div class="card-tools">
            <small class="text-white opacity-75">{{ now()->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>
 
    <form action="{{ route('user.journals.store') }}" method="POST" id="journalForm">
        @csrf
        <div class="card-body">
 
            {{-- Mood Selector --}}
            <div class="form-group">
                <label class="d-block">Bagaimana perasaan Anda hari ini?</label>
                <div class="py-1">
                    @foreach(['great' => '😄', 'good' => '🙂', 'neutral' => '😐', 'bad' => '😔', 'terrible' => '😢'] as $val => $emoji)
                        <input type="radio" name="mood" id="mood_{{ $val }}" value="{{ $val }}"
                               class="mood-option" {{ old('mood') == $val ? 'checked' : '' }}>
                        <label for="mood_{{ $val }}" title="{{ ucfirst($val) }}">{{ $emoji }}</label>
                    @endforeach
                </div>
                <small class="text-muted">Pilihan mood bersifat opsional.</small>
                @error('mood') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
 
            {{-- Judul --}}
            <div class="form-group">
                <label for="title">Judul Jurnal <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title"
                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="Beri judul untuk jurnal ini..."
                       autofocus required>
                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
 
            {{-- Konten dengan Quill.js --}}
            <div class="form-group">
                <label>Isi Jurnal <span class="text-danger">*</span></label>
                {{-- Editor container --}}
                <div id="quillEditor">{{ old('content') }}</div>
                {{-- Hidden input yang akan diisi oleh Quill --}}
                <input type="hidden" name="content" id="content">
                @error('content')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
 
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('user.journals.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save mr-1"></i> Simpan Jurnal
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
    placeholder: 'Tulis isi jurnal Anda di sini...',
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
 
// Saat form disubmit, ambil HTML dari Quill dan masukkan ke hidden input
document.getElementById('journalForm').addEventListener('submit', function(e) {
    const content = quill.root.innerHTML;
    const stripped = quill.getText().trim();
 
    if (stripped.length < 10) {
        e.preventDefault();
        alert('Isi jurnal minimal 10 karakter.');
        return;
    }
 
    document.getElementById('content').value = content;
});
</script>
@endpush