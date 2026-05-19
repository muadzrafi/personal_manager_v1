<?php

namespace App\Http\Controllers\Admin;
 
use App\Models\User;
use App\Models\Task;
use App\Models\FinancialRecord;
use App\Models\Journal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class AdminDashboardController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        // ─── Statistik Global (AGGREGATE ONLY) ───────────────
        // Gunakan withoutGlobalScopes() agar admin bisa query SEMUA data
        // tanpa terbatas user_id tertentu.
        // Namun hanya aggregate — BUKAN select * atau select individual rows.
 
        $globalStats = [
            // Total user terdaftar
            'total_users' => User::where('is_admin', false)->count(),
 
            // Total task yang dibuat di seluruh sistem
            'total_tasks' => Task::withoutGlobalScopes()->count(),
 
            // Total jurnal di seluruh sistem
            'total_journals' => Journal::withoutGlobalScopes()->count(),
 
            // Volume total transaksi di sistem (hanya angka, tanpa breakdown per user)
            'total_transaction_volume' => FinancialRecord::withoutGlobalScopes()->sum('amount'),
 
            // Rata-rata task per user
            'avg_tasks_per_user' => round(
                Task::withoutGlobalScopes()->count() /
                max(User::where('is_admin', false)->count(), 1), // hindari division by zero
                1
            ),
 
            // User baru bulan ini
            'new_users_this_month' => User::where('is_admin', false)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
 
        // ─── Tren Registrasi User (6 bulan) ──────────────────
        // Hanya jumlah, bukan nama atau detail user
        $userGrowth = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('is_admin', false)
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
 
        $growthLabels = [];
        $growthData   = [];
 
        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $found = $userGrowth->first(fn($r) =>
                $r->year == $date->year && $r->month == $date->month
            );
            $growthLabels[] = $date->format('M Y');
            $growthData[]   = $found ? $found->total : 0;
        }
 
        // ─── Distribusi Status Task (Global Aggregate) ────────
        $taskStatusDist = Task::withoutGlobalScopes()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status'); // ['pending' => 42, 'completed' => 18, ...]
 
        return view('admin.dashboard', [
            'globalStats'    => $globalStats,
            'growthLabels'   => json_encode($growthLabels),
            'growthData'     => json_encode($growthData),
            'taskStatusDist' => json_encode($taskStatusDist),
        ]);
    }
}
