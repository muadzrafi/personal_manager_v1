<?php

namespace App\Http\Controllers;
 
use App\Models\Task;
use App\Models\FinancialRecord;
use App\Models\Journal;
use Illuminate\Http\Request;
 
class SearchController extends Controller
{
    /**
     * GET /app/search?q=keyword
     * Global Scope di setiap model otomatis filter user_id
     */
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));
 
        if (strlen($query) < 2) {
            return view('search.index', [
                'query'   => $query,
                'tasks'   => collect(),
                'records' => collect(),
                'journals'=> collect(),
                'total'   => 0,
            ]);
        }
 
        // ─── Cari di Tasks ────────────────────────────────────
        $tasks = Task::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->take(10)
            ->get();
 
        // ─── Cari di Financial Records ────────────────────────
        $records = FinancialRecord::where('description', 'like', "%{$query}%")
            ->latest('recorded_at')
            ->take(10)
            ->get();
 
        // ─── Cari di Journals ─────────────────────────────────
        $journals = Journal::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->take(10)
            ->get();
 
        $total = $tasks->count() + $records->count() + $journals->count();
 
        return view('search.index', compact('query', 'tasks', 'records', 'journals', 'total'));
    }
}
 
