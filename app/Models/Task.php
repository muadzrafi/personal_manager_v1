<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Task extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];
 
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }
 
    // ─── Global Scope: DATA ISOLATION LAYER ───────────────────
    // Ini adalah kunci utama isolasi data!
    // Setiap query Task::... secara OTOMATIS akan menambahkan
    // WHERE user_id = auth()->id()
    // sehingga developer TIDAK BISA LUPA mem-filter data.
    protected static function booted(): void
    {
        static::addGlobalScope('owned_by_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('tasks.user_id', auth()->id());
            }
        });
    }
 
    // ─── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    // ─── Local Scopes (opsional, untuk filter tambahan) ───────
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }
 
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }
 
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('due_date', '>=', now()->toDateString())
                     ->orderBy('due_date');
    }
 
    // ─── Helper untuk badge warna priority ────────────────────
    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'high'   => 'danger',
            'medium' => 'warning',
            'low'    => 'success',
            default  => 'secondary',
        };
    }
 
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'completed'   => 'success',
            'in_progress' => 'primary',
            'pending'     => 'warning',
            'cancelled'   => 'secondary',
            default       => 'secondary',
        };
    }
}