@extends('layouts.master')
 
@section('title', 'Jurnal Harian')
@section('page-title', 'Jurnal Harian')
 
@section('breadcrumbs')
    <li class="breadcrumb-item active">Jurnal</li>
@endsection
 
@section('content')
 
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">{{ $journals->total() }} jurnal tersimpan</p>
    <a href="{{ route('user.journals.create') }}" class="btn btn-primary">
        <i class="fas fa-pen mr-1"></i> Tulis Jurnal Baru
    </a>
</div>
 
@forelse($journals as $journal)
{{-- ─── Card per Jurnal ─────────────────────────────────────── --}}
<div class="card card-outline card-primary mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="card-title mb-1">
                    <span class="mr-2" style="font-size:1.2rem">{{ $journal->mood_emoji }}</span>
                    <a href="{{ route('user.journals.show', $journal->id) }}" class="text-dark">
                        {{ $journal->title }}
                    </a>
                </h5>
                <span class="text-muted small">
                    <i class="fas fa-clock mr-1"></i>
                    {{ $journal->created_at->translatedFormat('l, d F Y') }}
                    — {{ $journal->created_at->format('H:i') }}
                    @if($journal->mood)
                        &nbsp;•&nbsp;
                        <span class="text-capitalize">{{ $journal->mood }}</span>
                    @endif
                </span>
            </div>
            <div class="btn-group btn-group-sm ml-3">
                <a href="{{ route('user.journals.edit', $journal->id) }}"
                   class="btn btn-outline-warning" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-outline-danger"
                        onclick="confirmDeleteJournal({{ $journal->id }}, '{{ addslashes($journal->title) }}')"
                        title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body py-2">
        {{-- Preview isi jurnal — strip HTML tag, potong 200 karakter --}}
        <p class="mb-0 text-muted">
            {{ Str::limit(strip_tags($journal->content), 200) }}
            @if(strlen(strip_tags($journal->content)) > 200)
                <a href="{{ route('user.journals.show', $journal->id) }}" class="text-primary ml-1">
                    Baca selengkapnya →
                </a>
            @endif
        </p>
    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-book-open fa-4x mb-3 d-block"></i>
        <h5>Belum ada jurnal.</h5>
        <p>Mulai tuliskan pikiran, perasaan, dan aktivitas harian Anda.</p>
        <a href="{{ route('user.journals.create') }}" class="btn btn-primary">
            <i class="fas fa-pen mr-1"></i> Tulis Jurnal Pertama
        </a>
    </div>
</div>
@endforelse
 
{{-- Pagination --}}
@if($journals->hasPages())
<div class="mt-3">
    {{ $journals->links() }}
</div>
@endif
 
<form id="deleteJournalForm" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>
@endsection
 
@push('scripts')
<script>
function confirmDeleteJournal(id, title) {
    if (confirm('Hapus jurnal "' + title + '"? Tindakan ini tidak bisa dibatalkan.')) {
        const form = document.getElementById('deleteJournalForm');
        form.action = '/app/journals/' + id;
        form.submit();
    }
}
</script>
@endpush