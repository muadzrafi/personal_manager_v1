<?php
// ============================================================
// FILE: app/Models/FinancialRecord.php
// Tambahkan scope business() yang sebelumnya belum ada
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'category',
        'amount',
        'description',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:2',
            'recorded_at' => 'date',
        ];
    }

    // ─── Global Scope: DATA ISOLATION ─────────────────────────
    protected static function booted(): void
    {
        static::addGlobalScope('owned_by_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('financial_records.user_id', auth()->id());
            }
        });
    }

    // ─── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Local Scopes ─────────────────────────────────────────
    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', 'expense');
    }

    public function scopePersonal(Builder $query): Builder
    {
        return $query->where('category', 'personal');
    }

    // ✅ Scope business() — sebelumnya belum ada, wajib ditambahkan
    public function scopeBusiness(Builder $query): Builder
    {
        return $query->where('category', 'business');
    }

    public function scopeCurrentMonth(Builder $query): Builder
    {
        return $query->whereYear('recorded_at', now()->year)
                     ->whereMonth('recorded_at', now()->month);
    }

    public function scopeCurrentYear(Builder $query): Builder
    {
        return $query->whereYear('recorded_at', now()->year);
    }
}