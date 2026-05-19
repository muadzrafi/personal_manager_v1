<?php
// ============================================================
// FILE: routes/web.php
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FinancialRecordController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\AdminDashboardController;
 
// ─── Root ──────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});
 
// ─── Route Group: User Panel ────────────────────────────────
Route::middleware(['auth', 'user.only'])
    ->prefix('app')
    ->name('user.')
    ->group(function () {
 
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 
        // ─── Pencarian Global ─────────────────────────────
        Route::get('/search', [SearchController::class, 'index'])->name('search');
 
        // ─── Profile & Settings ───────────────────────────
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/',          [ProfileController::class, 'index'])          ->name('index');
            Route::put('/info',      [ProfileController::class, 'updateInfo'])     ->name('update-info');
            Route::put('/password',  [ProfileController::class, 'updatePassword']) ->name('update-password');
            Route::put('/avatar',    [ProfileController::class, 'updateAvatar'])   ->name('update-avatar');
            Route::delete('/destroy',[ProfileController::class, 'destroy'])        ->name('destroy');
        });
 
        // ─── Tasks ────────────────────────────────────────
        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/',                [TaskController::class, 'index'])         ->name('index');
            Route::get('/create',          [TaskController::class, 'create'])        ->name('create');
            Route::post('/',               [TaskController::class, 'store'])         ->name('store');
            Route::get('/calendar/view',   [TaskController::class, 'calendar'])      ->name('calendar');
            Route::get('/calendar/events', [TaskController::class, 'calendarEvents'])->name('calendar.events');
            Route::get('/{task}',          [TaskController::class, 'show'])          ->name('show');
            Route::get('/{task}/edit',     [TaskController::class, 'edit'])          ->name('edit');
            Route::put('/{task}',          [TaskController::class, 'update'])        ->name('update');
            Route::delete('/{task}',       [TaskController::class, 'destroy'])       ->name('destroy');
        });
 
        // ─── Financial Records ────────────────────────────
        Route::prefix('financial')->name('financial.')->group(function () {
            Route::get('/',              [FinancialRecordController::class, 'index'])    ->name('index');
            Route::post('/',             [FinancialRecordController::class, 'store'])    ->name('store');
            Route::put('/{record}',      [FinancialRecordController::class, 'update'])   ->name('update');
            Route::delete('/{record}',   [FinancialRecordController::class, 'destroy'])  ->name('destroy');
            Route::get('/chart-data',    [FinancialRecordController::class, 'chartData'])->name('chart-data');
 
            // Export
            Route::get('/export/pdf',    [ExportController::class, 'exportPdf'])   ->name('export.pdf');
            Route::get('/export/excel',  [ExportController::class, 'exportExcel']) ->name('export.excel');
        });
 
        // ─── Journals ─────────────────────────────────────
        Route::prefix('journals')->name('journals.')->group(function () {
            Route::get('/',              [JournalController::class, 'index'])  ->name('index');
            Route::get('/create',        [JournalController::class, 'create']) ->name('create');
            Route::post('/',             [JournalController::class, 'store'])  ->name('store');
            Route::get('/{journal}',     [JournalController::class, 'show'])   ->name('show');
            Route::get('/{journal}/edit',[JournalController::class, 'edit'])   ->name('edit');
            Route::put('/{journal}',     [JournalController::class, 'update']) ->name('update');
            Route::delete('/{journal}',  [JournalController::class, 'destroy'])->name('destroy');
        });
    });
 
// ─── Route Group: Admin Panel ───────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
 
// ─── Auth Routes (dari Breeze) ──────────────────────────────
require __DIR__.'/auth.php';