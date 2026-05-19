@extends('layouts.master')
 
@section('title', $journal->title)
@section('page-title', 'Baca Jurnal')
 
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('user.journals.index') }}">Jurnal</a></li>
    <li class="breadcrumb-item active">Baca</li>
@endsection
 
@push('styles')
<style>
    .journal-content { font-size: 16px; line-height: 1.9; }
    .journal-content h1, .journal-content h2, .journal-content h3 {
        margin-top: 1.5rem; margin-bottom: .75rem;
    }
    .journal-content blockquote {
        border-left: 4px solid #dee2e6;
        padding-left: 1rem;
        color: #6c757d;
        font-style: italic;
    }
</style>
@endpush
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card">
    {{-- Header --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="mb-1">
                    <span class="mr-2">{{ $journal->mood_emoji }}</span>
                    {{ $journal->title }}
                </h4>
                <div class="text-muted small">
                    <i class="fas fa-calendar-day mr-1"></i>
                    {{ $journal->created_at->translatedFormat('l, d F Y — H:i') }}
                    @if($journal->mood)
                        &nbsp;•&nbsp; Mood: <strong>{{ ucfirst($journal->mood) }}</strong>
                    @endif
                </div>
            </div>
            <div class="btn-group btn-group-sm ml-3">
                <a href="{{ route('user.journals.edit', $journal->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <button type="button" class="btn btn-danger"
                        onclick="confirmDeleteJournal({{ $journal->id }}, '{{ addslashes($journal->title) }}')">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </div>
        </div>
    </div>
 
    {{-- Konten Jurnal --}}
    <div class="card-body">
        <div class="journal-content">
            {!! $journal->content !!}
        </div>
    </div>
 
    <div class="card-footer d-flex justify-content-between text-muted small">
        <span>
            <i class="fas fa-plus-circle mr-1"></i> Ditulis: {{ $journal->created_at->format('d M Y, H:i') }}
        </span>
        @if($journal->updated_at->gt($journal->created_at))
        <span>
            <i class="fas fa-pencil-alt mr-1"></i> Diperbarui: {{ $journal->updated_at->format('d M Y, H:i') }}
        </span>
        @endif
    </div>
</div>
 
{{-- Navigasi antar jurnal bisa ditambahkan di sini --}}
<div class="text-center">
    <a href="{{ route('user.journals.index') }}" class="btn btn-default btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Jurnal
    </a>
</div>
 
</div>
</div>
 
<form id="deleteJournalForm" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>
@endsection
 
@push('scripts')
<script>
function confirmDeleteJournal(id, title) {
    if (confirm('Hapus jurnal "' + title + '"?')) {
        const form = document.getElementById('deleteJournalForm');
        form.action = '/app/journals/' + id;
        form.submit();
    }
}
</script>
@endpush