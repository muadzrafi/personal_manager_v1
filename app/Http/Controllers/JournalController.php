<?php

namespace App\Http\Controllers;
 
use App\Models\Journal;
use App\Http\Requests\StoreJournalRequest;
 
class JournalController extends Controller
{
    /**
     * List semua jurnal milik user, urut terbaru.
     */
    public function index(): \Illuminate\View\View
    {
        // Global Scope otomatis filter user_id
        $journals = Journal::latest()->paginate(12);
        return view('journals.index', compact('journals'));
    }
 
    /**
     * Form buat jurnal baru.
     */
    public function create(): \Illuminate\View\View
    {
        return view('journals.create');
    }
 
    /**
     * Simpan jurnal baru.
     */
    public function store(StoreJournalRequest $request): \Illuminate\Http\RedirectResponse
    {
        $journal = Journal::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);
 
        return redirect()->route('user.journals.show', $journal->id)
                         ->with('success', 'Jurnal berhasil disimpan!');
    }
 
    /**
     * Detail jurnal.
     */
    public function show(Journal $journal): \Illuminate\View\View
    {
        // Global Scope sudah filter, tapi tetap double-check
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }
 
        return view('journals.show', compact('journal'));
    }
 
    /**
     * Form edit jurnal.
     */
    public function edit(Journal $journal): \Illuminate\View\View
    {
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }
 
        return view('journals.edit', compact('journal'));
    }
 
    /**
     * Update jurnal.
     */
    public function update(StoreJournalRequest $request, Journal $journal): \Illuminate\Http\RedirectResponse
    {
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }
 
        $journal->update($request->validated());
 
        return redirect()->route('user.journals.show', $journal->id)
                         ->with('success', 'Jurnal berhasil diperbarui!');
    }
 
    /**
     * Hapus jurnal.
     */
    public function destroy(Journal $journal): \Illuminate\Http\RedirectResponse
    {
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }
 
        $journal->delete();
 
        return redirect()->route('user.journals.index')
                         ->with('success', 'Jurnal berhasil dihapus!');
    }
}
