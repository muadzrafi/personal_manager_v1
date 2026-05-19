<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Journal extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'mood',
    ];
 
    // ─── Global Scope: DATA ISOLATION ─────────────────────────
    protected static function booted(): void
    {
        static::addGlobalScope('owned_by_user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('journals.user_id', auth()->id());
            }
        });
    }
 
    // ─── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    // ─── Helper untuk emoji mood ──────────────────────────────
    public function getMoodEmojiAttribute(): string
    {
        return match($this->mood) {
            'great'   => '😄',
            'good'    => '🙂',
            'neutral' => '😐',
            'bad'     => '😔',
            'terrible'=> '😢',
            default   => '📝',
        };
    }
}