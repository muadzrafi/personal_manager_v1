<?php

namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ FIX: tidak perlu cek auth()->check() di sini
        // Middleware 'auth' di route group sudah jalan lebih dulu
        if (!auth()->user()->is_admin) {
            abort(403, 'Anda tidak memiliki akses ke halaman Admin.');
        }
 
        return $next($request);
    }
}