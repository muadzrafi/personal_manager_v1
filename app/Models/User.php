<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
class User extends Authenticatable
{
    use HasFactory, Notifiable;
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'avatar',
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean', // cast ke boolean agar bisa if ($user->is_admin)
        ];
    }
 
    // ─── Relasi ───────────────────────────────────────────────
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
 
    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }
 
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}