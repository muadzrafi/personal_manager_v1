<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\FinancialRecord;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ─── Statistik Ringkas ────────────────────────────────
        $stats = [
            'total_tasks'     => Task::count(),
            'pending_tasks'   => Task::pending()->count(),
            'completed_tasks' => Task::completed()->count(),
            'total_journals'  => Journal::count(),
        ];

        // ─── Finansial Bulan Ini — Personal ───────────────────
        $personalIncome  = FinancialRecord::income()->personal()->currentMonth()->sum('amount');
        $personalExpense = FinancialRecord::expense()->personal()->currentMonth()->sum('amount');
        $personalBalance = $personalIncome - $personalExpense;

        // ─── Finansial Bulan Ini — Bisnis ─────────────────────
        $businessIncome  = FinancialRecord::income()->business()->currentMonth()->sum('amount');
        $businessExpense = FinancialRecord::expense()->business()->currentMonth()->sum('amount');
        $businessBalance = $businessIncome - $businessExpense;

        // ─── Chart Personal: Tren 6 Bulan ─────────────────────
        $personalChart = $this->getTrend6Months('personal');

        // ─── Chart Bisnis: Tren 6 Bulan ───────────────────────
        $businessChart = $this->getTrend6Months('business');

        // ─── Upcoming Tasks & Jurnal Terbaru ──────────────────
        $upcomingTasks  = Task::upcoming()
            ->whereIn('status', ['pending', 'in_progress'])
            ->take(5)
            ->get();

        $latestJournals = Journal::latest()->take(3)->get();

        return view('dashboard.index', [
            // Stats
            'stats'            => $stats,

            // Finansial Personal
            'personalIncome'   => $personalIncome,
            'personalExpense'  => $personalExpense,
            'personalBalance'  => $personalBalance,

            // Finansial Bisnis
            'businessIncome'   => $businessIncome,
            'businessExpense'  => $businessExpense,
            'businessBalance'  => $businessBalance,

            // Chart data (sudah json_encode)
            'personalChart'    => $personalChart,
            'businessChart'    => $businessChart,

            // List
            'upcomingTasks'    => $upcomingTasks,
            'latestJournals'   => $latestJournals,
        ]);
    }

    /**
     * Helper: ambil data tren income & expense 6 bulan terakhir
     * untuk satu kategori (personal atau business).
     * Return sudah dalam bentuk array siap json_encode.
     */
    private function getTrend6Months(string $category): array
    {
        $rows = FinancialRecord::select(
                DB::raw('YEAR(recorded_at) as year'),
                DB::raw('MONTH(recorded_at) as month'),
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            )
            ->where('category', $category)
            ->where('recorded_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = $income = $expense = [];

        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $found = $rows->first(
                fn($r) => $r->year == $date->year && $r->month == $date->month
            );
            $labels[]  = $date->format('M Y');
            $income[]  = $found ? (float) $found->total_income  : 0;
            $expense[] = $found ? (float) $found->total_expense : 0;
        }

        return [
            'labels'  => json_encode($labels),
            'income'  => json_encode($income),
            'expense' => json_encode($expense),
        ];
    }
}