<?php

namespace App\Http\Controllers;

use App\Models\FinancialRecord;
use App\Http\Requests\StoreFinancialRecordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialRecordController extends Controller
{
    /**
     * Halaman utama keuangan dengan tab Personal | Bisnis.
     * Parameter 'tab' di query string menentukan tab aktif.
     * Global Scope otomatis filter user_id.
     */
    public function index(Request $request): \Illuminate\View\View
    {
        // ─── Tab aktif: personal atau business ───────────────
        $tab  = $request->input('tab', 'personal'); // default tab personal
        $tab  = in_array($tab, ['personal', 'business']) ? $tab : 'personal';

        // ─── Filter tambahan ──────────────────────────────────
        $type  = $request->input('type', 'all');
        $month = $request->input('month', now()->format('Y-m'));

        [$filterYear, $filterMonth] = explode('-', $month);

        // ─── Query transaksi sesuai tab aktif ─────────────────
        $query = FinancialRecord::query()
            ->where('category', $tab)           // filter by tab
            ->whereYear('recorded_at', $filterYear)
            ->whereMonth('recorded_at', $filterMonth)
            ->orderBy('recorded_at', 'desc')
            ->orderBy('created_at', 'desc');

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $records = $query->paginate(20)->withQueryString();

        // ─── Summary tab aktif ────────────────────────────────
        $summary = FinancialRecord::query()
            ->where('category', $tab)
            ->whereYear('recorded_at', $filterYear)
            ->whereMonth('recorded_at', $filterMonth)
            ->select(
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            )->first();

        $totalIncome  = (float) ($summary->total_income  ?? 0);
        $totalExpense = (float) ($summary->total_expense ?? 0);
        $balance      = $totalIncome - $totalExpense;

        // ─── Tren 6 bulan tab aktif (untuk chart di halaman ini) ─
        $trendData = $this->getTrendData($tab);

        // ─── Summary badge di tab header (bulan ini) ──────────
        // Dipakai untuk menampilkan angka kecil di tab
        $personalSummary = $this->getMonthSummary('personal', $filterYear, $filterMonth);
        $businessSummary = $this->getMonthSummary('business', $filterYear, $filterMonth);

        return view('financial.index', [
            'records'         => $records,
            'totalIncome'     => $totalIncome,
            'totalExpense'    => $totalExpense,
            'balance'         => $balance,
            'trendData'       => $trendData,
            'activeTab'       => $tab,
            'filterMonth'     => $month,
            'filterType'      => $type,
            'personalSummary' => $personalSummary,
            'businessSummary' => $businessSummary,
        ]);
    }

    /**
     * Simpan transaksi baru.
     * category diambil dari hidden input (ditentukan dari tab aktif).
     */
    public function store(StoreFinancialRecordRequest $request): \Illuminate\Http\RedirectResponse
    {
        FinancialRecord::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        // Redirect kembali ke tab yang sesuai dengan kategori yang baru disimpan
        return redirect()->route('user.financial.index', [
                'tab'   => $request->input('category'),
                'month' => $request->input('recorded_at')
                    ? substr($request->input('recorded_at'), 0, 7)
                    : now()->format('Y-m'),
            ])
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Update transaksi.
     */
    public function update(StoreFinancialRecordRequest $request, FinancialRecord $record): \Illuminate\Http\RedirectResponse
    {
        if ($record->user_id !== auth()->id()) {
            abort(403);
        }

        $record->update($request->validated());

        return redirect()->route('user.financial.index', [
                'tab'   => $record->category,
                'month' => $record->recorded_at->format('Y-m'),
            ])
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Hapus transaksi.
     */
    public function destroy(FinancialRecord $record): \Illuminate\Http\RedirectResponse
    {
        if ($record->user_id !== auth()->id()) {
            abort(403);
        }

        $category    = $record->category;
        $recordMonth = $record->recorded_at->format('Y-m');

        $record->delete();

        return redirect()->route('user.financial.index', [
                'tab'   => $category,
                'month' => $recordMonth,
            ])
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Helper: ambil tren 6 bulan untuk satu kategori.
     */
    private function getTrendData(string $category): array
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
            ->orderBy('year')->orderBy('month')
            ->get();

        $labels = $income = $expense = [];

        for ($i = 5; $i >= 0; $i--) {
            $date   = now()->subMonths($i);
            $found  = $rows->first(fn($r) => $r->year == $date->year && $r->month == $date->month);
            $labels[]  = $date->format('M Y');
            $income[]  = $found ? (float) $found->total_income  : 0;
            $expense[] = $found ? (float) $found->total_expense : 0;
        }

        return compact('labels', 'income', 'expense');
    }

    /**
     * Helper: ambil summary income/expense bulan tertentu per kategori.
     * Dipakai untuk badge di tab header.
     */
    private function getMonthSummary(string $category, string $year, string $month): array
    {
        $data = FinancialRecord::query()
            ->where('category', $category)
            ->whereYear('recorded_at', $year)
            ->whereMonth('recorded_at', $month)
            ->select(
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
            )->first();

        return [
            'income'  => (float) ($data->income  ?? 0),
            'expense' => (float) ($data->expense ?? 0),
            'balance' => (float) ($data->income ?? 0) - (float) ($data->expense ?? 0),
        ];
    }

    /**
     * Endpoint JSON untuk Chart.js — tren 6 bulan per kategori.
     */
    public function chartData(Request $request): \Illuminate\Http\JsonResponse
    {
        $category = $request->input('category', 'personal');
        $category = in_array($category, ['personal', 'business']) ? $category : 'personal';

        $data = $this->getTrendData($category);

        return response()->json($data);
    }
}